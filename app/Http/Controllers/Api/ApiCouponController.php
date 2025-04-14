<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\CouponService;
use App\Services\CouponValidator;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiCouponController extends Controller
{
    use HttpResponse;

    protected $couponValidator;
    protected $couponService;

    public function __construct(CouponValidator $couponValidator, CouponService $couponService)
    {
        $this->couponValidator = $couponValidator;
        $this->couponService = $couponService;
    }
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $cartCacheKey = 'cart_' . auth('sanctum')->user()->id;
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return $this->sendResponse([], 'Coupon not found', 404);
        }

        $cart = Cache::get($cartCacheKey, []);
        if (!$cart) {
            return $this->sendResponse([], 'Cart is empty', 200);
        }

        try {
            $this->couponValidator->validateCoupon($coupon);

            $subtotal = collect($cart)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });

            $totalAfterDiscount = $this->couponService->calculateDiscountedAmount($coupon, $subtotal);
            $discountAmount = $subtotal - $totalAfterDiscount;
            $coupon->increment('used_count');

            Cache::put($cartCacheKey, array_merge($cart, [
                'applied_coupon' => $couponCode,
                'discounted_total' => $totalAfterDiscount,
                'discount_amount' => $discountAmount,
            ]));

            return $this->sendResponse([
                'total' => $totalAfterDiscount,
                'discount_amount' => $discountAmount,
                'currency' => 'EGP'
            ], 'Coupon is applied successfully', 200);
        } catch (\Exception $e) {
            return $this->sendResponse([], $e->getMessage(), 400);
        }
    }

    public function cancelCoupon()
    {
        $userID = auth()->user()->id;
        $cartCacheKey = 'cart_' . $userID;

        $cart = Cache::get($cartCacheKey, []);

        if (empty($cart)) {
            return $this->sendResponse([], 'Cart is empty', 200);
        }

        unset($cart['applied_coupon'], $cart['discounted_total'], $cart['discount_amount']);

        Cache::put($cartCacheKey, $cart);

        $originalTotal = collect($cart)->sum(function ($item) {
            return isset($item['price'], $item['quantity']) ? $item['price'] * $item['quantity'] : 0;
        });

        return $this->sendResponse([
            'original_total' => $originalTotal,
            'currency' => 'EGP'
        ], 'Coupon is cancelled successfully', 200);
    }
}
