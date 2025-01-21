<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiCheckoutController extends Controller
{
    use HttpResponse;

    public function index()
    {
        $user = auth('sanctum')->user();
        $cartCacheKey = 'cart_' . $user->id;
        $cartItems = Cache::get($cartCacheKey);

        if (!$cartItems) {
            return $this->sendResponse([],
                'Cart is empty. Please add items to your cart before proceeding to checkout.',
                400);
        }

        // Filter out non-product entries
        $products = array_filter($cartItems, function ($item) {
            return is_array($item) && isset($item['price']) && isset($item['quantity']);
        });

        $subtotal = collect($products)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $appliedCoupon = $cartItems['applied_coupon'] ?? null;
        $discountedTotal = $cartItems['discounted_total'] ?? null;
        $discountAmount = $cartItems['discount_amount'] ?? null;

        return $this->sendResponse([
            'cart_items' => $products,
            'subtotal' => $subtotal,
            'applied_coupon' => $appliedCoupon,
            'discounted_total' => $discountedTotal,
            'discount_amount' => $discountAmount,
        ], 'success');
    }

}
