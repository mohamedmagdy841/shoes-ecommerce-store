<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StripePaymentService extends BasePaymentService implements PaymentGatewayInterface
{

    protected mixed $api_key;
    public function __construct()
    {
        $this->base_url =env("STRIPE_BASE_URL");
        $this->api_key = env("STRIPE_SECRET_KEY");
        $this->header = [
            'Accept' => 'application/json',
            'Content-Type' =>'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer ' . $this->api_key,
        ];

    }

    public function sendPayment(Request $request, $user, $amount): array
    {
        $data = $this->formatData($request, $amount);
        $response =$this->buildRequest('POST', '/v1/checkout/sessions', $data, 'form_params');
        if($response->getData(true)['success']) {
            Log::info('response', [$response->getData(true)]);
            return ['success' => true, 'url' => $response->getData(true)['data']['url']];
        }
        Log::warning('Stripe payment failed', ['response' => $response->getData(true)]);
        return ['success' => false,'url'=>route('payment.failed')];
    }

    public function callBack(Request $request): bool
    {
        $session_id = $request->get('session_id');
        $response=$this->buildRequest('GET','/v1/checkout/sessions/'.$session_id);
        Storage::put('stripe.json',json_encode([
            'callback_response'=>$request->all(),
            'response'=>$response,
        ]));
        if($response->getData(true)['success']&& $response->getData(true)['data']['payment_status']==='paid') {
            Cache::put('payment_method', 'stripe', now()->addMinutes(30));
            return true;
        }
        return false;

    }

    public function formatData($request, $amount): array
    {
        $user = $request->user();
        $cartItems = \Cart::session($user->id)->getContent();

        $lineItems = [];

        foreach ($cartItems as $item) {
            $lineItems[] = [
                "price_data" => [
                    "currency" => $request->input("currency", "usd"),
                    "unit_amount" => $item->price * 100, // Stripe uses cents
                    "product_data" => [
                        "name" => $item->name,
                        "description" => "Product description", // Optional
                    ],
                ],
                "quantity" => $item->quantity,
            ];
        }

        return [
            "success_url" => $request->getSchemeAndHttpHost().'/payment/callback?session_id={CHECKOUT_SESSION_ID}',
            "cancel_url" => route("payment.failed"),
            "line_items" => $lineItems,
            "mode" => "payment",
        ];
    }

}
