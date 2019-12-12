<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderModel extends Model
{
    public $primaryKey = 'id';

    protected $guarded = array();

    public function __construct($options = [])
    {
        parent::__construct($options);
        $this->table = $this->tableName();
    }

    protected function tableName()
    {
        return 'order';
    }

    public function addOrder($params) {
        if (is_null(DB::table('users')->find($params['user_id']))) {
            return ["error" => ["user_id" => ["User id not exists!"]], "status_code" => 422];
        }

        $order = new OrderModel();
        $order->user_id = $params['user_id'];
        $order->number_of_visa = $params['number_of_visa'];
        $order->visa_type = $params['visa_type'];
        $order->purpose = $params['purpose'];
        $order->airport_arrival = $params['airport_arrival'];
        $order->process_type = $params['process_type'];
        $order->is_full_packet_service = isset($params['is_full_packet_service']) ? 'yes' : 'no';
        $order->airport_fast_track = isset($params['airport_fast_track']) ? $params['airport_fast_track'] : 'no';
        $order->car_pick_up	 = isset($params['car_pick_up']) ? $params['car_pick_up'] : null;
        $order->date_of_arrival = $params['date_of_arrival'];
        $order->date_of_departure = $params['date_of_departure'];
        $order->payment_type = $params['payment_type'];
        $order->special_request = isset($params['special_request']) ? $params['special_request'] : null;
        // add an method to caculate total money
        $order->total_money = $params['total_money'];
        $order->created_at = date('Y-m-d H:i:s');
        $order->updated_at = date('Y-m-d H:i:s');
        $order->save();
        return $order->id;
    }

    public function getOrder($params) {
        $data = [];
        $select = OrderModel::select("*")
        ->when(isset($params['purpose']), function ($query) use ($params) {
            return $query->where('purpose', '=', $params['purpose']);
        })
        ->when(isset($params['number_of_visa']), function ($query) use ($params) {
            return $query->where('number_of_visa', 'LIKE', '%'.$params['purpose'].'%');
        })
        ->when(isset($params['user_id']), function ($query) use ($params) {
            return $query->where('user_id', '=', $params['user_id']);
        })
        ->when(isset($params['visa_type']), function ($query) use ($params) {
            return $query->where('visa_type', '=', $params['visa_type']);
        })
        ->when(isset($params['airport_arrival']), function ($query) use ($params) {
            return $query->where('airport_arrival', 'LIKE', '%'.$params['airport_arrival'].'%');
        })
        ->when(isset($params['process_type']), function ($query) use ($params) {
            return $query->where('process_type', '=', $params['process_type']);
        })
        ->when(isset($params['date_of_arrival']), function ($query) use ($params) {
            return $query->where('date_of_arrival', '=', $params['date_of_arrival']);
        })
        ->when(isset($params['status_order']), function ($query) use ($params) {
            return $query->where('status_order', '=', $params['status_order']);
        })
        ->when(isset($params['date_of_departure']), function ($query) use ($params) {
            return $query->where('date_of_departure', '=', $params['date_of_departure']);
        });
		$data['total'] = $select->count();
		$data['total'] = intval($data['total']/$params['limit'] + 0.9);
        $data['data']  = $select->skip(intval($params['offset']))
            ->take($params['limit'])
            ->orderByRaw($params['sort'] . ' ' . $params['order'])->get()->toArray();

        $data['data'] = array_map(function($eachRow) {
            $eachRow['orderDetail'] = DB::table('order_detail')->select("*")
                ->where('order_id', $eachRow['id'])
                ->get()->toArray();

            $eachRow['applicant'] = count($eachRow['orderDetail']);
            return $eachRow;
        }, $data['data']);


        $data['pagination'] = [
            'total' => $data['total'],
            'per_page' => $params['limit'],
            'current_page' => $params['offset'] + 1,
            'last_page' => $data['total'],
        ];

        return $data;
    }

    public function getOrderById($id) {
        $select = OrderModel::find($id);
        if (is_null($select)) {
            return [];
        }
        $select = $select->toArray();
        $select['children'] = DB::table('order_detail')->select("*")
        ->where('order_id', $select['id'])
        ->get()->keyBy('id');

        return json_decode(json_encode($select), true);
    }

    public function getOrderDetailById($id) {

    }

    public function updateOrder($params) {
        OrderModel::where('id', $params['id'])
        ->update(['purpose' => $params['purpose'],
                'number_of_visa' => $params['number_of_visa'],
                'visa_type' => $params['visa_type'],
                'date_of_arrival' => date('Y-m-d', strtotime($params['date_of_arrival'])),
                'date_of_departure' => date('Y-m-d', strtotime($params['date_of_departure'])),
                'airport_fast_track' => $params['airport_fast_track'],
                'car_pick_up' => $params['car_pick_up'],
                'updated_at' => date('Y-m-d H:i:s')
        ]);

        return ['status' => true, 'message' => 'Cập nhập thành công'];
    }

    public function updateOrderDetail($params) {
        DB::table('order_detail')->where('id', $params['id'])
        ->update([
                'passport_full_name' => $params['passport_full_name'],
                'passport_gender' => $params['passport_gender'],
                'passport_date_of_birth' => date('Y-m-d', strtotime($params['passport_date_of_birth'])),
                'nationality' => $params['nationality'],
                'passport_number' => $params['passport_number'],
                'updated_at' => date('Y-m-d H:i:s')
        ]);

        return ['status' => true, 'message' => 'Cập nhập thành công'];
    }

    public function deleteOrder($id)
    {
        OrderModel::where('id', $id)->delete();
    }

    public function updateStatus($id) {
        OrderModel::where('id', $id)->update(['status_order' => 'success']);
    }
}
