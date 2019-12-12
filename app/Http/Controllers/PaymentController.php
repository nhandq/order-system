<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use App\OrderModel;
use App\Profile;
use Redirect;
use Session;
use URL;
use App\User;
use Illuminate\Support\Facades\Input;

class PaymentController extends Controller
{
  private $_api_context;
  private $orderModel;
  private $mailControl;
  private $user;
  private $profiles;

  public function __construct()
  {
    /** PayPal api context **/
    $this->user = new User();
    $this->profiles = new Profile();
    $this->mailControl = new MailController();
    $this->orderModel = new OrderModel();
    $paypal_conf = \Config::get('paypal');
    $this->_api_context = new ApiContext(new OAuthTokenCredential(
        $paypal_conf['client_id'],
        $paypal_conf['secret'])
    );
    $this->_api_context->setConfig($paypal_conf['settings']);
  }

  public function payWithpaypal(Request $request)
  {
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');
    $item_1 = new Item();
    $item_1->setName('Item 1') /** item name **/
        ->setCurrency('USD')
        ->setQuantity(1)
        ->setPrice($request->get('total_money')); /** unit price **/
    $item_list = new ItemList();
    $item_list->setItems(array($item_1));
    $amount = new Amount();
    $amount->setCurrency('USD')
        ->setTotal($request->get('total_money'));
    $transaction = new Transaction();
    $transaction->setAmount($amount)
        ->setItemList($item_list)
        ->setDescription('Your transaction description');
    $redirect_urls = new RedirectUrls();
    $redirect_urls->setReturnUrl(URL::to('api/status?user_id='.$request['user_id'].'&order_id='.$request['order_id'])) /** Specify return URL **/
        ->setCancelUrl(URL::to('api/status?user_id='.$request['user_id']));
    $payment = new Payment();
    $payment->setIntent('Sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));
    try {
      $payment->create($this->_api_context);
    } catch (\PayPal\Exception\PPConnectionException $ex) {
      if (\Config::get('app.debug')) {
        \Session::put('error', 'Connection timeout');
        return Redirect::to('/');
      } else {
        \Session::put('error', 'Some error occur, sorry for inconvenient');
        return Redirect::to('/');
      }
    }

    foreach ($payment->getLinks() as $link) {
      if ($link->getRel() == 'approval_url') {
        $redirect_url = $link->getHref();
        break;
      }
    }
    /** add payment ID to session **/
    Session::put('paypal_payment_id', $payment->getId());
    Session::put('paypal_link', $redirect_url);
    if (isset($redirect_url)) {
      /** redirect to paypal **/
      $request['paymentLink'] = $redirect_url;
      $request['email'] = $this->user->getMail($request['user_id']);
      $request['full_name'] = $this->user->getName($request['user_id']);
      $this->mailControl->sendRemindMail($request);
      return Redirect::away($redirect_url);
    }
    \Session::put('error', 'Unknown error occurred');
    return Redirect::to('/');
  }

  public function getPaymentStatus(Request $request)
  {
    /** Get the payment ID before session clear **/
    $payment_id = Session::get('paypal_payment_id');
    /** clear the session payment ID **/
    Session::forget('paypal_payment_id');
    Session::forget('paypal_link');
    if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
      \Session::put('error', 'Payment failed');
      $this->orderModel->updateStatus($request['order_id']);
      $request->request->add(['mail' => $this->user->getMail($request['user_id'])]);
      $request->request->add(['name' => $this->user->getName($request['user_id'])]);

      return Redirect::to('/');
    }
    $payment = Payment::get($payment_id, $this->_api_context);
    $execution = new PaymentExecution();
    $execution->setPayerId(Input::get('PayerID'));
    /**Execute the payment **/
    $result = $payment->execute($execution, $this->_api_context);
    if ($result->getState() == 'approved') {
      \Session::put('success', 'Payment success');
      $this->orderModel->updateStatus($request['order_id']);
      $orderDetail = $this->orderModel->getOrderById($request['order_id']);
      $request->request->add($orderDetail);
      $request->request->add(['mail' => $this->user->getMail($request['user_id'])]);
      $request->request->add(['full_name' => $this->user->getName($request['user_id'])]);
      //send success mail
      $this->mailControl->sendSuccessMail($request);
      return Redirect::to('/order');
    }
    \Session::put('error', 'Payment failed');
    $this->orderModel->updateStatus($request['order_id']);
    //send remind mail
    return Redirect::to('/order');
  }
}
