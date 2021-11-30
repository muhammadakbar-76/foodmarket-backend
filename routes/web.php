<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\MidtransController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//homepage
Route::get('/', function () {
    return redirect()->route("dashboard");
});

//dashboard
Route::prefix("dashboard")
->middleware(["auth:sanctum","isAdmin"])
->group(function(){
    Route::get("/", [DashboardController::class, "index"])->name("dashboard");
    Route::resource('/users', UserController::class);
    Route::resource('/food', FoodController::class);
    Route::get("transaction/{id}/status/{status}", [TransactionController::class, "changeStatus"])->name("transaction.changeStatus");
    Route::resource('/transaction', TransactionController::class);
});

//Midtrans route, masukan route-route ini ke midtrans vtweb/snap jika sudah dihosting
Route::get("midtrans/success", [MidtransController::class, "success"]);
Route::get("midtrans/unfinish", [MidtransController::class, "unfinish"]);
Route::get("midtrans/error", [MidtransController::class, "error"]);