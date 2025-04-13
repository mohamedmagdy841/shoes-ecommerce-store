<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Cart;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrderFromCart($user, array $orderData)
    {
        $cartItems = Cart::session($user->id)->getContent();

        $appliedCoupon = session('applied_coupon', null);
        $discountedTotal = session('discounted_total', null);
        $discountedAmount = session('discount_amount', null);

        $totalAmount = $discountedTotal ?? $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'payment_method' => $orderData['payment_method'] ?? 'cash',
                'total_price' => $totalAmount,
                'coupon_code' => $appliedCoupon,
                'discount_amount' => $discountedAmount,
            ]);

            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item->id);

                if ($product->qty < $item->quantity) {
                    throw new \Exception("Product '{$product->name}' out of stock");
                }

                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                $product->decrement('qty', $item->quantity);
            }

            Cart::session($user->id)->clear();
            session()->forget(['applied_coupon', 'discounted_total', 'discount_amount']);
            Cache::forget('cart_' . $user->id);

            DB::commit();
            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function calculateCartTotal($user): array
    {
        $cartItems = Cart::session($user->id)->getContent();

        if ($cartItems->isEmpty()) {
            throw new \Exception("Cart is empty");
        }

        $appliedCoupon = session('applied_coupon', null);
        $discountedTotal = session('discounted_total', null);
        $discountAmount = session('discount_amount', null);

        $totalAmount = $discountedTotal ?? $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        return [
            'total' => $totalAmount,
            'coupon_code' => $appliedCoupon,
            'discount_amount' => $discountAmount,
            'cart_items' => $cartItems,
        ];
    }

}
