<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(8);
        return view('frontend.order', compact('orders'));
    }

    public function cashOrder(StoreOrderRequest $request)
    {

        $user = auth()->user();
        $cartItems = Cart::session($user->id)->getContent();

        if ($cartItems->isEmpty()) {
            notyf()->error('Your cart is empty');
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $appliedCoupon = session('applied_coupon', null);
            $discountedTotal = session('discounted_total', null);
            $discountedAmount = session('discount_amount', null);

            $totalAmount = $discountedTotal ?? $cartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            $validatedData = $request->validated();

            $order = $user->orders()->create([
                'total_price' => $totalAmount,
                'payment_method' => $validatedData['payment_method'],
                'coupon_code' => $appliedCoupon,
                'discount_amount' => $discountedAmount,
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                $product = Product::find($item->id);
                if ($product) {
                    if ($product->qty < $item->quantity) {
                        notyf()->error('Not enough stock for product');
                        return redirect()->back();
                    }
                    $product->decrement('qty', $item->quantity);
                }
            }

            Cart::session($user->id)->clear();
            session()->forget(['applied_coupon', 'discounted_total', 'discount_amount']);
            Cache::forget('cart_' . $user->id);

            DB::commit();

            return view('frontend.confirmation', ['order' => $order, 'user' => $user]);

        } catch (\Exception $e) {
            DB::rollBack();
            notyf()->error('Failed to place order');
            return redirect()->back();
        }
    }


    public function stripeOrder(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::session($user->id)->getContent();

        if ($cartItems->isEmpty()) {
            notyf()->error('Your cart is empty');
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $appliedCoupon = session('applied_coupon', null);
            $discountedTotal = session('discounted_total', null);
            $discountedAmount = session('discount_amount', null);

            $totalAmount = $discountedTotal ?? $cartItems->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $token = $request->input('stripeToken');

            Charge::create([
                'amount' => $totalAmount*100,
                'currency' => 'EGP',
                'description' => 'Karma Store',
                'source' => $token,
            ]);

            $order = Order::create([
                'user_id' => $user->id,
                'payment_method' => $request->input('payment_method'),
                'total_price' => $totalAmount,
                'coupon_code' => $appliedCoupon,
                'discount_amount' => $discountedAmount,
                'created_at' => Carbon::now(),
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                $product = Product::find($item->id);
                if ($product) {
                    if ($product->qty < $item->quantity) {
                        notyf()->error('Not enough stock for product');
                        return redirect()->back();
                    }
                    $product->decrement('qty', $item->quantity);
                }
            }

            Cart::session($user->id)->clear();
            session()->forget(['applied_coupon', 'discounted_total', 'discount_amount']);
            Cache::forget('cart_' . $user->id);

            DB::commit();

            return view('frontend.confirmation', ['order' => $order, 'user' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            notyf()->error('Failed to place order');
            return redirect()->back();
        }

    }
    public function orderInvoiceDownload($id)
    {
        $order = auth()->user()->orders()->with('items.product')->where('status', 'completed')->findOrFail($id);
        $pdf = Pdf::loadView('frontend.invoice_download',compact('order'))
            ->setPaper('a4')->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
        return $pdf->download('invoice.pdf');
    }

}
