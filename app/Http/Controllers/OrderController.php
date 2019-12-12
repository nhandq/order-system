<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\OrderModel;
use App\OrderDetailModel;
use GuzzleHttp\Client;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
  private $orderModel;
  private $orderDetailModel;

  public function __construct()
  {
    $this->orderModel = new OrderModel();
    $this->orderDetailModel = new OrderDetailModel();
  }

  public function addOrder(OrderRequest $request)
  {
    $input = $request->all();

    if ((count($input['passport_full_name']) + count($input['passport_full_name']) + count($input['passport_full_name']) + count($input['passport_full_name']) + count($input['passport_full_name'])) % 5 != 0 ) {
      return response()->json(['error' => ['passport_number' => 'Wrong number of passport member!'], 'status_code' => 422], 422);
    }
    // should add check user name $input['user_id']
    //

    //store order to DB
    $orderId = $this->orderModel->addOrder($input);
    if (isset($orderId['error'])) {
      return response()->json($orderId, 422);
    }

    $input['order_id'] = $orderId;
    $input['order_date'] = date('Y-m-d H:i:s');
    foreach ($input['passport_full_name'] as $index => $value) {
      $input['orderDetail'][$index]['name'] = $value;
      $input['orderDetail'][$index]['gender'] = $input['passport_gender'][$index];
      $input['orderDetail'][$index]['birthday'] = $input['passport_date_of_birth'][$index];
      $input['orderDetail'][$index]['nationality'] = $input['nationality'][$index];
      $input['orderDetail'][$index]['passportNumber'] = $input['passport_number'][$index];
    }
    $input['service_fee'] = isset($input['is_full_packet_service']) ? 50 : (isset($input['airport_fast_track']) ? 19 : 0);
    $input['service_fee'] += isset($input['airport_fast_track']) ? (($input['airport_fast_track'] == '4 seat') ? 10 : (($input['airport_fast_track'] == '7 seat') ? 15 : (($input['airport_fast_track'] == '16 seat') ? 20 : 25) ) ) : 0;

    //store order detail to DB
    $orderDetail = $this->orderDetailModel->addOrderDetail($input);

    if ($orderDetail === true) {
      //call api to get payment method
      // $client = new Client(['base_uri' => 'http://my.order.com:9090']);
      try{
        // $client->post('/api/paypal', ['json' => ['order_id' => $orderId, 'amount' => $input['total_money']]]);
        $paypalRequest = new \Illuminate\Http\Request();
        $paypalRequest->replace($input);
        $paypalRequest->header = $request->header;
        return (new PaymentController())->payWithpaypal($paypalRequest);

      }
      catch(\Exception $ex){
        Log::error('['.date('d-m-y H:i:s').']  --- Sending sms get error: '.$ex);
      }
      return response()->json(['status' => true, 'message' => 'Add order success!', 'status_code' => 200]);
    }

    return response()->json($orderDetail, 422);
  }

  public function getOrder(Request $request)
  {
    $params = $request->all();
    //default
    $params['offset']       = $request->input('offset', 0);
    $params['limit']        = $request->input('limit', 5);
    $params['order']        = 'desc';
    $params['sort']         = 'id';

    $result = $this->orderModel->getOrder($params);

    return response()->json([
      'total' => $result['total'],
      'data'  => $result['data'],
      'pagination' => $result['pagination'],
    ]);
  }

  public function getOrderDetail($id, Request $request)
  {
    return response()->json(['status' => true, 'data' => $this->orderModel->getOrderById($id)]);
  }

  public function updateOrder($id, Request $request)
  {
    if (!$request->input('status', false)) {
      return response()->json(['status' => false, 'message' => 'Đơn hàng không tồn tại']);
    }
    if (!preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/i', $request->input('status'))){
      return response()->json(['status' => false, 'message' => 'Visa không hợp lệ']);
    }
    return response()->json($this->orderModel->updateOrder($request->input('number_of_visa')));
  }

  public function updateOrderDetail($id, Request $request)
  {
    if (!isset($request->all()[$id])) {
      response()->json(['status' => false, 'message' => 'Đơn hàng không tồn tại']);
    }

    return response()->json($this->orderModel->updateOrderDetail($request->all()[$id]));
  }

  public function deleteOrder($orderId) {
    $this->orderModel->deleteOrder($orderId);
    $this->orderDetailModel->delete($orderId);
  }
}
