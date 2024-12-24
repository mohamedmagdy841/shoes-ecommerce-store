<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PaymentGatewayInterface $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {

        $this->paymentGateway = $paymentGateway;
    }


    public function paymentProcess(Request $request)
    {

        return $this->paymentGateway->sendPayment($request);
    }

    public function callBack(Request $request): \Illuminate\Http\RedirectResponse
    {
        $response = $this->paymentGateway->callBack($request);
        if ($response) {
            // create order in database
            return redirect()->route('payment.success');
        }
        return redirect()->route('payment.failed');
    }



    public function success()
    {

        return view('frontend.payments.paymob.payment-success');
    }
    public function failed()
    {

        return view('frontend.payments.paymob.payment-failed');
    }
}
