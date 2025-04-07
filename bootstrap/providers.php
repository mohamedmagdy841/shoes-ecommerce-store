<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\CacheServiceProvider::class,
    App\Providers\CheckSettingProvider::class,
    Darryldecode\Cart\CartServiceProvider::class,
    Barryvdh\DomPDF\ServiceProvider::class,
    App\Providers\PaymentServiceProvider::class,
];
