<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->get();
        return view('frontend.order', compact('orders'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::session($user->id)->getContent();

        if ($cartItems->isEmpty()) {
            notyf()->error('Your cart is empty');
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            // Calculate total amount
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            // Create order
            $order = $user->orders()->create([
                'total_price' => $totalAmount,
            ]);

            // Add order items
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            // Clear the cart
            Cart::session($user->id)->clear();

            DB::commit();

            return view('frontend.confirmation', ['order' => $order, 'user' => $user]);

        } catch (\Exception $e) {
            DB::rollBack();
            notyf()->error('Failed to place order');
            return redirect()->back();
        }
    }

//    public function show($id)
//    {
//        $order = auth()->user()->orders()->with('items.product')->findOrFail($id);
//
//        return view('frontend.orders.show', compact('order'));
//    }

}
