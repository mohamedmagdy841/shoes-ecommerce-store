<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::post('/payment/process', [PaymentController::class, 'paymentProcess']);
//Route::match(['GET','POST'],'/payment/callback', [PaymentController::class, 'callBack']);
