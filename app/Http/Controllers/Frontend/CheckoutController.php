<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;

class CheckoutController extends Controller
{
    public function index()
    {

        $user = auth()->user();
        $cartItems = Cart::session($user->id)->getContent();
        if($cartItems->isEmpty()){
            return to_route('frontend.cart.get');
        }

        $subtotal = Cart::session($user->id)->getSubtotal();
        return view('frontend.checkout', compact('cartItems', 'subtotal', 'user'));
    }
}
