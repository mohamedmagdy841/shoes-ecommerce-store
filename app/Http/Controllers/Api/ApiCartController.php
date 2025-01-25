<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CouponService;
use App\Services\CouponValidator;
use App\Traits\HttpResponse;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiCartController extends Controller
{
    use HttpResponse;
    protected $couponValidator;
    protected $couponService;

    public function __construct(CouponValidator $couponValidator, CouponService $couponService)
    {
        $this->couponValidator = $couponValidator;
        $this->couponService = $couponService;
    }

    public function get()
    {
        $userID = auth('sanctum')->user()->id;
        $cartCacheKey = 'cart_' . $userID;
        $cart = Cache::get($cartCacheKey);

        if (!$cart){
            return $this->sendResponse([]
            , 'Cart is empty.');
        }

        return $this->sendResponse([
            'cart' => $cart,
            'cartCount' => count($cart),
        ], 'Cart retrieved successfully.');
    }

    public function add($productId)
    {
        $quantity = request()->input('quantity', 1);
        $product = Product::findOrFail($productId);
        $userID = auth('sanctum')->user()->id;

        $cartCacheKey = 'cart_' . $userID;

        $cart = Cache::get($cartCacheKey);

        if (isset($cart[$product->full_name])) {
            $cart[$product->full_name]['quantity'] += 1;
        } else {
            $cart[$product->full_name] = [
                'id' => $productId,
                'name' => $product->full_name,
                'price' => $product->price,
                'quantity' => $quantity,
                'attributes' => [
                    'image' => $product->images->first()->path,
                ]
            ];
        }

        Cache::put($cartCacheKey, $cart, now()->addHours(1));

        return $this->sendResponse($cart, 'Item added to cart successfully.');
    }

    public function remove($productId)
    {
        $userID = auth('sanctum')->user()->id;
        $cartCacheKey = 'cart_' . $userID;
        $cart = Cache::get($cartCacheKey);
        $product = Product::findOrFail($productId);

        if(isset($cart[$product->full_name])){
            unset($cart[$product->full_name]);
            Cache::put($cartCacheKey, $cart, now()->addHours(1));
            return $this->sendResponse($cart, 'Item removed from cart successfully.');
        }
        return $this->sendResponse([], 'Item not found.', 404);
    }

    public function removeAll()
    {
        $userID = auth('sanctum')->user()->id;
        $cartCacheKey = 'cart_' . $userID;
        Cache::forget($cartCacheKey);
        return $this->sendResponse([], 'All items removed from cart successfully.');
    }

    public function updateQuantity($productId, $action)
    {
        $userID = auth('sanctum')->user()->id;
        $cartCacheKey = 'cart_' . $userID;
        $cart = Cache::get($cartCacheKey);
        $product = Product::findOrFail($productId);

        if(!isset($cart[$product->full_name])){
            return $this->sendResponse([], 'Item not found.', 404);
        }

        $quantityChange = $action === 'increase' ? +1 : -1;

        $cart[$product->full_name]['quantity'] += $quantityChange;

        if($cart[$product->full_name]['quantity'] < 1){
            unset($cart[$product->full_name]);
        }

        Cache::put($cartCacheKey, $cart, now()->addHours(1));

        $message = $action === 'increase'
            ? 'Quantity increased successfully!'
            : 'Quantity decreased successfully!';

        return $this->sendResponse($cart, $message);
    }
}
