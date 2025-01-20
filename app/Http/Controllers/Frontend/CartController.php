<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Services\CouponService;
use App\Services\CouponValidator;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Number;

class CartController extends Controller
{

    protected $couponValidator;
    protected $couponService;

    public function __construct(CouponValidator $couponValidator, CouponService $couponService)
    {
        $this->couponValidator = $couponValidator;
        $this->couponService = $couponService;
    }
    public function get()
    {
        $userID = auth()->user()->id;
        $cartCacheKey = 'cart_' . $userID;
        $cart = Cache::get($cartCacheKey);

        if (!Cache::has($cartCacheKey)) {
            $items = Cart::session($userID)->getContent();
            $subtotal = Cart::session($userID)->getSubtotal();

            $cart = [
                'items' => $items,
                'subtotal' => $subtotal,
            ];

            Cache::put($cartCacheKey, $cart, now()->addMinutes(30));
        }
        return $cart;
        $items = collect($cart['items']);
        $subtotal = $cart['subtotal'];

        if (request()->ajax()) {
            return response()->json(['cartCount' => $items->count()]);
        }

        return view('frontend.cart', compact('items', 'subtotal'));
    }

    public function add($productId)
    {
        $product = Product::findOrFail($productId);
        $userID = auth()->user()->id;

        Cart::session($userID)->add(array(
            'id' => $productId,
            'name' => $product->full_name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(
                'image' => $product->images->first()->path,
            ),
            'associatedModel' => $product
        ));

        $cartCacheKey = 'cart_' . $userID;
        Cache::forget($cartCacheKey);

        return response()->json(['message' => 'Item added to cart successfully!']);
    }

    public function remove($productId)
    {
        $userID = auth()->user()->id;
        Cart::session($userID)->remove($productId);

        $cartCacheKey = 'cart_' . $userID;
        Cache::forget($cartCacheKey);

        return response()->json(['message' => 'Item removed successfully!']);
    }

    public function updateQuantity($productId, $action)
    {
        $userID = auth()->user()->id;

        $quantityChange = $action === 'increase' ? +1 : -1;

        Cart::session($userID)->update($productId, [
            'quantity' => $quantityChange,
        ]);

        $cartCacheKey = 'cart_' . $userID;
        Cache::forget($cartCacheKey);

        $message = $action === 'increase'
            ? 'Quantity increased successfully!'
            : 'Quantity decreased successfully!';

        return response()->json(['message' => $message]);
    }

    public function clearCart()
    {
        $userID = auth()->user()->id;
        Cart::session($userID)->clear();

        $cartCacheKey = 'cart_' . $userID;
        Cache::forget($cartCacheKey);

        notyf()->success('Cart cleared successfully!');
        return redirect()->back();
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
