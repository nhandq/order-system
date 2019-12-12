<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
  public function basic_email() {
    $data = array('name'=>"Virat Gandhi");

    Mail::send(['text'=>'mail'], $data, function($message) {
        $message->to('abc@gmail.com', 'Tutorials Point')->subject
          ('Laravel Basic Testing Mail');
        $message->from('xyz@gmail.com','Virat Gandhi');
    });
    echo "Basic Email Sent. Check your inbox.";
  }

  public function sendSuccessMail($request) {
    $data = $request->all();

    Mail::send('mail-success', $data, function($message) use($data){
        $message->to($data['mail'], $data['full_name'])->subject
          ('Đơn hàng #'.$data['order_id'].' của bạn tại XXX đã hoàn tất');
        $message->from('xyz@gmail.com', 'Nhandq');
    });
  }

  public function sendRemindMail($params) {
    //convert object to array
    $params = json_decode(json_encode($params->all()), true);
    Mail::send('mail-remind', $params, function($message) use($params) {
        $message->to($params['email'], 'Tutorials Point')->subject
          ('Re: Payment Request Visa To VietNam For Order #'.$params['order_id']);
        $message->from('xyz@gmail.com','Nhandq');
    });
    echo "HTML Email Sent. Check your inbox.";
  }

  public function sendErrorMail(Request $request) {
    $data = array('name'=> $request->input('name', '___'));

    Mail::send('mail', $data, function($message) use($request){
        $message->to($request->input('mail', 'nhandq.coder@gmail.com'), 'Tutorials Point')->subject
          ('Please checkout your order!');
        $message->from('xyz@gmail.com','LAB System');
    });
  }

  public function html_email(Request $request) {
    $data = $request->all();
    // dd($data);
    Mail::send('mail-success', $data, function($message) {
        $message->to('nhandq.dev@gmail.com', 'Tutorials Point')->subject
          ('Laravel HTML Testing Mail');
        $message->from('xyz@gmail.com','Virat Gandhi');
    });
    echo "HTML Email Sent. Check your inbox.";
  }

  public function attachment_email() {
    $data = array('name'=>"Virat Gandhi");
    Mail::send('mail', $data, function($message) {
        $message->to('abc@gmail.com', 'Tutorials Point')->subject
          ('Laravel Testing Mail with Attachment');
        $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
        $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
        $message->from('xyz@gmail.com','Virat Gandhi');
    });
    echo "Email Sent with attachment. Check your inbox.";
  }
}
