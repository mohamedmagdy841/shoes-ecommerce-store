<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected PaymentGatewayInterface $paymentGateway;
    protected OrderService $orderService;

    public function __construct(PaymentGatewayInterface $paymentGateway, OrderService $orderService)
    {

        $this->paymentGateway = $paymentGateway;
        $this->orderService = $orderService;

    }

    public function paymentProcess(Request $request)
    {
        $user = auth()->user();

        try {
            $cartInfo = $this->orderService->calculateCartTotal($user);
            // store cart in cache or DB for callback
            Cache::put('cart_snapshot_user_' . $user->id, $cartInfo, now()->addMinutes(30));

        } catch (\Exception $e) {
            notyf()->error($e->getMessage());
            return redirect()->back();
        }

        $response= $this->paymentGateway->sendPayment($request, $user, $cartInfo['total']);

        if($request->is('api/*')){

            return response()->json($response, 200);
        }

        return redirect($response['url']);
    }

    public function callBack(Request $request): \Illuminate\Http\RedirectResponse
    {
        $response = $this->paymentGateway->callBack($request);

        if ($response && isset($response['userId'])) {

            $user = User::find($response['userId']);
            $this->orderService->createOrderFromCart($user, [
                'payment_method' => 'myfatoorah',
            ]);

            return redirect()->route('payment.success');
        }
        Log::warning('Callback response', ['response' => $response]);
        return redirect()->route('payment.failed');
    }

    public function success()
    {

        return view('frontend.payments.payment-success');
    }
    public function failed()
    {

        return view('frontend.payments.payment-failed');
    }

}
