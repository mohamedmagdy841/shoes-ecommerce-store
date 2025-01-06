<?php

use App\Http\Controllers\Api\ApiHomeController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiShopController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
//
//// Home
//Route::get('/', [ApiHomeController::class, 'index']);
//
//// Products
//Route::controller(ApiProductController::class)->prefix('product')->group(function () {
//    Route::get('/{slug}', [ApiProductController::class, 'show']);
//    Route::post('/review', [ApiProductController::class, 'addReview']);
//});
//
//// Shop
//Route::get('/shop', [ApiShopController::class, 'index']);

//Route::post('/payment/process', [PaymentController::class, 'paymentProcess']);
//Route::match(['GET','POST'],'/payment/callback', [PaymentController::class, 'callBack']);
