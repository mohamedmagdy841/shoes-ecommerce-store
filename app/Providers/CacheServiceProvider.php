<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
//        Cache::forget('home_products');
        if(!Cache::has('home_products')){
            $home_products = Product::with('images')->latest()->limit(16)->get();
            Cache::remember('home_products', 3600, function () use ($home_products) {
                return $home_products;
            });
        }

        $home_products = Cache::get('home_products');

        View::share('home_products', $home_products);
    }
}
