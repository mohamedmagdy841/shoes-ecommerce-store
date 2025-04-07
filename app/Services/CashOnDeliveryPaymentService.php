<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CashOnDeliveryPaymentService implements PaymentGatewayInterface
{
    public function sendPayment(Request $request, $user, $amount)
    {
        $data = $request->all();

        if ($data) {
            Log::info('Cash on delivery send payment', ['response' => $data]);
            return ['success' => true, 'url' => route('payment.callBack')];
        }
        Log::warning('Cash on delivery payment failed', ['response' => $data]);
        return ['success' => false,'url'=>route('payment.failed')];

    }

    public function callback(Request $request): bool
    {
        Cache::put('payment_method', 'cash_on_delivery', now()->addMinutes(30));
        return true;
    }
}
