<?php

namespace App\Services;

use App\Models\Coupon;

class CouponService
{
    public function calculateDiscountedAmount(Coupon $coupon, int $originalAmount): int
    {
        $discountAmount = 0;

        if ($coupon->type === 'fixed') {
            $discountAmount = (int) $coupon->value;
        } elseif ($coupon->type === 'percentage') {
            $discountAmount = $this->calculatePercentageDiscount((int) $coupon->value, $originalAmount);
        }

        return $originalAmount - $discountAmount;
    }

    private function calculatePercentageDiscount(int $percentage, int $originalAmount): int
    {
        return (int) ($percentage / 100 * $originalAmount);
    }
}
