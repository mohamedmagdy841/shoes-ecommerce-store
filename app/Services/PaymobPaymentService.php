<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PaymobPaymentService extends BasePaymentService implements PaymentGatewayInterface
{
    /**
     * Create a new class instance.
     */
    protected $api_key;
    protected $integrations_id;

    public function __construct()
    {
        $this->base_url = env("PAYMOB_BASE_URL");
        $this->api_key = env("PAYMOB_API_KEY");

        $this->header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->integrations_id = [4902100, 5038004];

    }

    protected function generateToken()
    {
        $response = $this->buildRequest('POST', '/api/auth/tokens', ['api_key' => $this->api_key]);
        return $response->getData(true)['data']['token'];
    }

    public function sendPayment(Request $request, $user, $amount):array
    {
        $this->header['Authorization'] = 'Bearer ' . $this->generateToken();
        //validate data before sending it
        $data = $request->all();
        $data['api_source'] = "INVOICE";
        $data['amount_cents'] = $amount * 100;
        $data['currency'] = env('PAYMOB_CURRENCY', 'EGP');
        $data['shipping_data'] = [
            'first_name' => $user->name,
            'last_name' => "Gamal",
            'phone_number' => $user->phone ?? '01000000000',
            'email' => $user->email,
        ];
        $data['integrations'] = $this->integrations_id;
        $response = $this->buildRequest('POST', '/api/ecommerce/orders', $data);

        if ($response->getData(true)['success']) {
            Log::info('response', [$response->getData(true)]);
            return ['success' => true, 'url' => $response->getData(true)['data']['url']];
        }

        Log::warning('Paymob payment failed', ['response' => $response->getData(true)]);
        return ['success' => false, 'url' => route('payment.failed')];
    }

    public function callBack(Request $request): bool
    {
        $response = $request->all();
        Storage::put('paymob_response.json', json_encode($request->all()));

        if (isset($response['success']) && $response['success'] === 'true') {
            Cache::put('payment_method', 'paymob', now()->addMinutes(30));
            return true;
        }
        return false;

    }


}
