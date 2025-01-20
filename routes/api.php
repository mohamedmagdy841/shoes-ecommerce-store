<?php

use App\Http\Controllers\Api\ApiCartController;
use App\Http\Controllers\Api\ApiContactController;
use App\Http\Controllers\Api\ApiCouponController;
use App\Http\Controllers\Api\ApiHomeController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiShopController;
use App\Http\Controllers\Api\ApiSubscriberController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\Password\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::get('/getUser', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
    Route::post('/logout-all', 'logoutAll')->middleware('auth:sanctum');
});

// Forgot Password
Route::post('/password/email', [ForgotPasswordController::class, 'sendOtpEmail']);

// Reset Password
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword']);

// Verify Email
Route::middleware('auth:sanctum')->controller(VerifyEmailController::class)->group(function(){
    Route::post('auth/email/verify', 'verifyEmail');
    Route::get('auth/email/verify', 'sendOtpAgain');
});

// Home
Route::get('/', [ApiHomeController::class, 'index']);

// Products
Route::controller(ApiProductController::class)->prefix('product')->group(function () {
    Route::get('/{slug}',  'show');
    Route::post('/review',  'addReview');
});

// Shop
Route::get('/shop', [ApiShopController::class, 'index']);

// Contact
Route::middleware(['auth:sanctum', 'verifyEmail'])->controller(ApiContactController::class)->prefix('contact')->group(function () {
    Route::post('/store',  'store');
});


// Cart
Route::middleware(['auth:sanctum', 'checkUserStatus'])->controller(ApiCartController::class)->prefix('cart')->group(function () {
    Route::get('/',  'get');
    Route::post('/{id}', 'add');
    Route::delete('/{id}', 'remove');
    Route::delete('/', 'removeAll');
    Route::patch('/{id}/update-quantity/{action}',  'updateQuantity');
});

// Coupon
Route::middleware(['auth:sanctum', 'checkUserStatus'])->controller(ApiCouponController::class)->prefix('coupon')->group(function () {
    Route::post('/apply_coupon',  'applyCoupon');
    Route::get('/cancel_coupon',  'cancelCoupon');
});

// newsletter
Route::post('/newsletter', [ApiSubscriberController::class, 'store']);

//Route::post('/payment/process', [PaymentController::class, 'paymentProcess']);
//Route::match(['GET','POST'],'/payment/callback', [PaymentController::class, 'callBack']);
