<?php

use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get("user",[UserController::class, "fetch"]);
    Route::post("user",[UserController::class, "updateProfile"]);
    Route::post("user/photo",[UserController::class, "updatePhoto"]);
    Route::post("logout",[UserController::class, "logout"]);

    Route::get("transaction", [TransactionController::class, "all"]);
    Route::post("transaction/{id}", [TransactionController::class, "update"]);

    Route::post("checkout", [TransactionController::class, "checkout"]);
});

Route::post("login", [UserController::class, "login"]);

Route::post("register", [UserController::class, "register"]);

Route::get("food", [FoodController::class, "all"]);

Route::post("midtrans/callback", [MidtransController::class, "callback"]); //route ini harus diisi ke midtrans dashboard bagian callback (harus dihosting lah)