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
        // Skip caching when running tests or in CI environments
        if (app()->environment('testing', 'ci')) {
            return;
        }

//        Cache::forget('home_products');
        if(!Cache::has('home_products')){
            $home_products = Product::with('images')->latest()->limit(16)->get();
            Cache::remember('home_products', 3600, function () use ($home_products) {
                return $home_products;
            });
        }

        //        Cache::forget('cheapest_products');
        if(!Cache::has('cheapest_products')){
            $cheapest_products = Product::with('images')->orderBy('price')->limit(9)->get();
            Cache::remember('cheapest_products', 3600, function () use ($cheapest_products) {
                return $cheapest_products;
            });
        }

        $cheapest_products = Cache::get('cheapest_products');
        $home_products = Cache::get('home_products');

        View::share('home_products', $home_products);
        View::share('cheapest_products', $cheapest_products);
    }
}
