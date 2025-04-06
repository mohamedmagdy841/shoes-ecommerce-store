<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\User;
use App\Services\OrderService;
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
        $response = $this->paymentGateway->callBack($request);

        if ($response && isset($response['userId'])) {

            $user = User::find($response['userId']);
            $order = $this->orderService->createOrderFromCart($user, [
                'payment_method' => 'myfatoorah',
            ]);

            Log::info('Callback success response', ['response' => $response]);
            return view('frontend.confirmation', ['order' => $order, 'user' => $user]);
        }
        Log::warning('Callback failed response', ['response' => $response]);
        return redirect()->route('payment.failed');
    }

//    public function success()
//    {
//        return view('frontend.payments.payment-success');
//    }
    public function failed()
    {
        return view('frontend.payments.payment-failed');
    }

}
