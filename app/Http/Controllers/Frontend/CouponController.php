<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\CouponService;
use App\Services\CouponValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Number;
use Cart;
class CouponController extends Controller
{
    protected $couponValidator;
    protected $couponService;

    public function __construct(CouponValidator $couponValidator, CouponService $couponService)
    {
        $this->couponValidator = $couponValidator;
        $this->couponService = $couponService;
    }

    public function applyCoupon(Request $request)
    {
        $userID = auth()->user()->id;
        $couponCode = $request->input('coupon_code');
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code'], 400);
        }

        try {
            Cache::forget('cart_'.$userID);
            $subtotal = Cart::session($userID)->getSubtotal();

            $this->couponValidator->validateCoupon($coupon);
            $totalAfterDiscount = $this->couponService->calculateDiscountedAmount($coupon, $subtotal);
            $coupon->increment('used_count');

            session([
                'applied_coupon' => $couponCode,
                'discounted_total' => $totalAfterDiscount,
                'discount_amount' => $subtotal - $totalAfterDiscount,
            ]);

            return response()->json(['success' => true, 'total' => Number::currency($totalAfterDiscount, 'EGP')]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cancelCoupon()
    {
        session()->forget(['applied_coupon', 'discounted_total','discount_amount' ]);

        $userID = auth()->user()->id;
        $originalTotal = Cart::session($userID)->getSubtotal();

        return response()->json([
            'success' => true,
            'original_total' => Number::currency($originalTotal, 'EGP'),
        ]);
    }
}
