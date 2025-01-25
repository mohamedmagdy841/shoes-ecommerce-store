<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Product;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Stripe;
use Barryvdh\DomPDF\Facade\Pdf;

class ApiOrderController extends Controller
{
    use HttpResponse;

    public function index()
    {
        $orders = auth('sanctum')->user()->orders()->with('items.product')->latest()->paginate(8);
        if($orders->isEmpty()){
            return $this->sendResponse([], 'No orders found');
        }
        return $this->sendResponse($orders, 'Orders retrieved successfully.');
    }

    public function cashOrder(StoreOrderRequest $request)
    {
        $user = auth()->user();
        $cartItems = Cache::get('cart_' . $user->id, []);

        if (empty($cartItems)) {
            return $this->sendResponse([], 'Cart is empty.', 400);
        }

        DB::beginTransaction();

        try {
            $appliedCoupon = $cartItems['applied_coupon'] ?? null;
            $discountedTotal = $cartItems['discounted_total'] ?? null;
            $discountAmount = $cartItems['discount_amount'] ?? null;

            $products = array_filter($cartItems, function ($item) {
                return is_array($item) && isset($item['price']) && isset($item['quantity']);
            });

            $totalAmount = $discountedTotal ?? collect($products)->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });

            $validatedData = $request->validated();

            $order = $user->orders()->create([
                'total_price' => $totalAmount,
                'payment_method' => $validatedData['payment_method'],
                'coupon_code' => $appliedCoupon,
                'discount_amount' => $discountAmount,
            ]);

            foreach ($products as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product = Product::find($item->id);
                if ($product) {
                    if ($product->qty < $item->quantity) {
                        return $this->sendResponse([],
                            'Not enough stock for product',
                            422);
                    }
                    $product->decrement('qty', $item->quantity);
                }
            }

            Cache::forget('cart_' . $user->id);
            Cache::forget('applied_coupon');
            Cache::forget('discounted_total');
            Cache::forget('discount_amount');

            DB::commit();

            return $this->sendResponse($order, 'Order placed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendResponse([],
                'Failed to place order '.$e->getMessage(),
                500);
        }
    }

    public function stripeOrder(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cache::get('cart_' . $user->id, []);

        if (empty($cartItems)) {
            return $this->sendResponse([], 'Cart is empty.', 400);
        }

        DB::beginTransaction();

        try {
            $appliedCoupon = $cartItems['applied_coupon'] ?? null;
            $discountedTotal = $cartItems['discounted_total'] ?? null;
            $discountAmount = $cartItems['discount_amount'] ?? null;

            $products = array_filter($cartItems, function ($item) {
                return is_array($item) && isset($item['price']) && isset($item['quantity']);
            });

            $totalAmount = $discountedTotal ?? collect($products)->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $token = $request->input('stripeToken');

            Charge::create([
                'amount' => $totalAmount * 100, // Stripe expects the amount in cents
                'currency' => 'EGP',
                'description' => 'Karma Store',
                'source' => $token,
            ]);

            $order = $user->orders()->create([
                'total_price' => $totalAmount,
                'payment_method' => 'stripe',
                'coupon_code' => $appliedCoupon,
                'discount_amount' => $discountAmount,
            ]);

            foreach ($products as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $product = Product::find($item->id);
                if ($product) {
                    if ($product->qty < $item->quantity) {
                        return $this->sendResponse([],
                            'Not enough stock for product',
                            422);
                    }
                    $product->decrement('qty', $item->quantity);
                }
            }

            Cache::forget('cart_' . $user->id);
            Cache::forget('applied_coupon');
            Cache::forget('discounted_total');
            Cache::forget('discount_amount');

            DB::commit();

            return $this->sendResponse($order, 'Order placed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return $this->sendResponse([], 'Failed to place order: ' . $e->getMessage(), 500);
        }
    }

    public function orderInvoiceDownload($id)
    {
        try {
            $order = auth('sanctum')->user()
                ->orders()
                ->with('items.product')
                ->where('status', 'completed')
                ->findOrFail($id);

            // Generate the PDF
            $pdf = Pdf::loadView('frontend.invoice_download', compact('order'))
                ->setPaper('a4')
                ->setOption([
                    'tempDir' => public_path(),
                    'chroot' => public_path(),
                ]);

            // Return the PDF as a response
            return response($pdf->download(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice.pdf"',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Order not found or not completed',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
