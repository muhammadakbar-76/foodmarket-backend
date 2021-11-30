<?php

namespace App\Http\Controllers\Api;

use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback(Request $request){
        //set config midtrans
        Config::$serverKey = config("services.midtrans.serverKey");
        Config::$isProduction = config("services.midtrans.isProduction");
        Config::$isSanitized = config("services.midtrans.isSanitized");
        Config::$is3ds = config("services.midtrans.is3ds");

        //make midtrans notification instance
        $notification = new Notification();

        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        //search transaction by id
        $transaction = Transaction::findOrFail($order_id);
        
        //handle midtrans notification status
        if ($status == "capture") {
            if ($type == "credit_card") {
                if ($fraud == "challenge") {
                    $transaction->status = "PENDING";
                }
                else {
                    $transaction->status = "SUCCESS";
                }
            }
        }
        elseif ($status == "settlement") {
            $transaction->status = "SUCCESS";
        }
        elseif ($status == "pending") {
            $transaction->status = "PENDING";
        }
        elseif ($status == "deny") {
            $transaction->status = "CANCELLED";
        }
        elseif ($status == "expire") {
            $transaction->status = "CANCELLED";
        }
        elseif ($status == "cancel") {
            $transaction->status = "CANCELLED";
        }

        //save transaction
        $transaction->save();
    }

    public function success(Request $request){
        return view("midtrans.success");
    }

    public function unfinish(Request $request){
        return view("midtrans.unfinish");
    }

    public function error(Request $request){
        return view("midtrans.error");
    }
}
