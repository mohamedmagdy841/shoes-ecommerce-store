<?php

namespace App\Services;

use App\Models\Coupon;

class CouponValidator
{
    public function validateCoupon(Coupon $coupon): void
    {
        $today = now()->toDateString();

        if ($today < $coupon->start_date) {
            throw new \Exception("Coupon has not started");
        }

        if ($coupon->end_date < $today) {
            throw new \Exception("Coupon code has expired");
        }
        if ($coupon->used_count >= $coupon->limit) {
            throw new \Exception("Coupon usage has been exceeded");
        }
    }
}
