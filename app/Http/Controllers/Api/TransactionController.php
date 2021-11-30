<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function all(Request $request){
        $id = $request->id;
        $limit = $request->input("limit", 6); //bedanya input() dgn dynamic props, kita bisa nentuin default value
        $food_id = $request->food_id;
        $status = $request->status;

        if ($id) {

           $transaction = Transaction::with(["food","user"])->find($id);

            if ($transaction) {
                return ResponseFormatter::success(
                    $transaction,
                    "Transaction Data has been successfully fetched"
                );
            }

            return ResponseFormatter::error(
                null,
                "Transaction not found",
                404
            );
        }

        $transaction = Transaction::with(["food","user"])->where("user_id",Auth::user()->id);

        if ($food_id) {
            $transaction->where("food_id",$food_id);
        }

        if ($status) {
            $transaction->where("status",$status);
        }
        

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            "Transaction Data has been successfully fetched"
        );
    }

    public function update(Request $request, $id){ //gak perlu data model binding?
        $transaction = Transaction::findOrFail($id);

        $transaction->update($request->all());

        return ResponseFormatter::success($transaction, "transaction has been updated");
    }

    public function checkout(Request $request){
       $data = $request->validate([
            "food_id" => "required|exists:food,id",
            "user_id" => "required|exists:users,id",
            "quantity" => "required",
            "total" => "required",
            "status" => "required",
        ]);

        $data["payment_url"] = "";

        $transaction = Transaction::create($data);

        //configure midtrans
        Config::$serverKey = config("services.midtrans.serverKey");
        Config::$isProduction = config("services.midtrans.isProduction");
        Config::$isSanitized = config("services.midtrans.isSanitized");
        Config::$is3ds = config("services.midtrans.is3ds");

        //call the transaction
        $transaction = Transaction::with(["user","food"])->find($transaction->id);

        //make midtrans transaction
        $midtrans = [
            "transaction_details" => [
                "order_id" => $transaction->id,
                "gross_amount" => (int) $transaction->total
            ],
            "customer_details" => [
                "first_name" => $transaction->user->name,
                "email" => $transaction->user->email,
            ],
            "enabled_payments" => ["gopay","bank_transfer"],
            "vtweb" => []
        ];

        //call midtrans
        try {
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            return ResponseFormatter::success($transaction,"Transaction Success");

        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(),"Transaction Failed");
        }
       
    }
}
