<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\User;
use App\Services\CashOnDeliveryPaymentService;
use App\Services\MyFatoorahPaymentService;
use App\Services\OrderService;
use App\Services\PaymobPaymentService;
use App\Services\StripePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Cart;

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
        } catch (\Exception $e) {
            notyf()->error($e->getMessage());
            return redirect()->back();
        }

        $response= $this->paymentGateway->sendPayment($request, $user, $cartInfo['total']);

        return redirect($response['url']);
    }

    public function callBack(Request $request)
    {
        $user = auth()->user();

        $gatewayType = $this->resolveGatewayTypeFromRequest($request);

        $gateway = match ($gatewayType) {
            'stripe' => new StripePaymentService(),
            'paymob' => new PaymobPaymentService(),
            'myfatoorah' => new MyFatoorahPaymentService(),
            'cash_on_delivery' => new CashOnDeliveryPaymentService(),
            default => throw new \Exception("Unsupported gateway type: $gatewayType"),
        };

        $response = $gateway->callBack($request);

        if ($response) {
            $payment_method = Cache::get('payment_method', 'Cash');
            $order = $this->orderService->createOrderFromCart($user, [
                'payment_method' => $payment_method,
            ]);
            Cache::forget('payment_method');
            Log::info('Callback success response', ['response' => $response]);
            return view('frontend.confirmation', ['order' => $order, 'user' => $user]);
        }
        Log::warning('Callback failed response', ['response' => $response]);
        return redirect()->route('payment.failed');
    }


    private function resolveGatewayTypeFromRequest(Request $request): string
    {
        if ($request->has('paymentId')) {
            return 'myfatoorah';
        }

        if ($request->has('id') && $request->has('hmac')) {
            return 'paymob';
        }

        if ($request->hasHeader('stripe-signature')) {
            return 'stripe';
        }

        return 'cash_on_delivery';
    }

    public function failed()
    {
        return view('frontend.payments.payment-failed');
    }

}
