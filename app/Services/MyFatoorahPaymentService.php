<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MyFatoorahPaymentService extends BasePaymentService implements PaymentGatewayInterface
{
    /**
     * Create a new class instance.
     */
    protected $api_key;
    public function __construct()
    {
        $this->base_url = env("MYFATOORAH_BASE_URL");
        $this->api_key = env("MYFATOORAH_API_KEY");
        $this->header = [
            'accept' => 'application/json',
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . $this->api_key,
        ];
    }

    public function sendPayment(Request $request, $user, float $amount): array
    {
        $data = $request->all();
        $data['NotificationOption'] = "LNK";
        $data['MobileCountryCode'] = "+2";
        $data['UserDefinedField'] = $user->id;
        $data['CustomerName'] = $user->name;
        $data['CustomerMobile'] = $user->phone;
        $data['CustomerEmail'] = $user->email;
        $data['InvoiceValue'] = $amount;
        $data['CallBackUrl'] = route('payment.callBack');
        $response = $this->buildRequest('POST', '/v2/SendPayment', $data);
        //handel payment response data and return it
        if($response->getData(true)['success'] && $response->getData(true)['data']['IsSuccess']){
            Log::info('MyFatoorah send payment', ['response' => $response->getData(true)]);
             return ['success' => true,'url' => $response->getData(true)['data']['Data']['InvoiceURL']];
        }
        Log::warning('MyFatoorah payment failed', ['response' => $response->getData(true)]);
        return ['success' => false,'url'=>route('payment.failed')];
    }

    public function callBack(Request $request)
    {
        $data=[
            'KeyType' => 'paymentId',
            'Key' => $request->input('paymentId'),
        ];
        $response=$this->buildRequest('POST', '/v2/getPaymentStatus', $data);
        $response_data=$response->getData(true);
        Log::info('MyFatoorah test', ['response' => $response_data]);
        Storage::put('myfatoorah_response.json',json_encode([
            'myfatoorah_callback_response'=>$request->all(),
            'myfatoorah_response_status'=>$response_data
        ]));

        if($response_data['data']['Data']['InvoiceStatus']==='Paid'){
            Cache::put('payment_method', 'myfatoorah', now()->addMinutes(30));
            return true;
        }

        return false;
    }

}
