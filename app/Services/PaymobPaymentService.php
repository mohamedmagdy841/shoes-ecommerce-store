<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\Request;
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
        if (empty($this->base_url) || empty($this->api_key)) {
            throw new \InvalidArgumentException('Paymob configuration is not set properly in the .env file.');
        }
        $this->header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->integrations_id = [4902100];

    }

//first generate token to access api
    protected function generateToken()
    {
        $response = $this->buildRequest('POST', '/api/auth/tokens', ['api_key' => $this->api_key]);
dd($response);
//        return $response;
//        return $response->getData(true)['data']['token'];
    }

    public function sendPayment(Request $request):array
    {
        $this->header['Authorization'] = 'Bearer ' . $this->generateToken();
        //validate data before sending it
        $data = $request->all();
        $data['api_source'] = "INVOICE";
        $data['integrations'] = $this->integrations_id;

        $response = $this->buildRequest('POST', '/api/ecommerce/orders', $data);
        //handel payment response data and return it
        if ($response->getData(true)['success']) {


            return ['success' => true, 'url' => $response->getData(true)['data']['url']];
        }

        return ['success' => false, 'url' => route('payment.failed')];
    }

    public function callBack(Request $request): bool
    {
        $response = $request->all();
        Storage::put('paymob_response.json', json_encode($request->all()));

        if (isset($response['success']) && $response['success'] === 'true') {

            return true;
        }
        return false;

    }


}