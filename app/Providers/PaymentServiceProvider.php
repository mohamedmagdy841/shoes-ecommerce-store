<?php

namespace App\Providers;

use App\Interfaces\PaymentGatewayInterface;
use App\Services\CashOnDeliveryPaymentService;
use App\Services\MyFatoorahPaymentService;
use App\Services\PaymobPaymentService;
use App\Services\StripePaymentService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {


        $this->app->singleton(PaymentGatewayInterface::class, function ($app) {
            $gatewayType = request()->get('gateway_type', 'paymob');

            return match ($gatewayType) {
                'stripe' => new StripePaymentService(),
                'paymob' => new PaymobPaymentService(),
                'myfatoorah' => new MyFatoorahPaymentService(),
                'cash_on_delivery' => new CashOnDeliveryPaymentService(),
                default => throw new \Exception("Unsupported gateway type: $gatewayType"),
            };
        });

//        $this->app->bind(PaymentGatewayInterface::class, MyFatoorahPaymentService::class);
//        $this->app->bind(PaymentGatewayInterface::class, PaymobPaymentService::class);
//        $this->app->bind(PaymentGatewayInterface::class, StripePaymentService::class);
//        $this->app->bind(PaymentGatewayInterface::class, CashOnDeliveryPaymentService::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
