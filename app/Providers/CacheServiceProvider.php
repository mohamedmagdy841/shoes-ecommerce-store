<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
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

        if (!Schema::hasTable('products')) {
            View::share('home_products', collect()); // Default empty
            View::share('cheapest_products', collect()); // Default empty
            return; // Exit early if products table doesn’t exist
        }

        if (!Cache::has('home_products')) {
            $hasProducts = Product::exists();

            if ($hasProducts) {
                Cache::remember('home_products', 3600, function () {
                    return Product::with('images')->latest()->limit(16)->get();
                });
            }
        }

        if (!Cache::has('cheapest_products')) {
            $hasProducts = Product::exists();

            if ($hasProducts) {
                Cache::remember('cheapest_products', 3600, function () {
                    return Product::with('images')->orderBy('price')->limit(9)->get();
                });
            }
        }

        $home_products = Cache::get('home_products', collect());
        $cheapest_products = Cache::get('cheapest_products', collect());

        View::share('home_products', $home_products);
        View::share('cheapest_products', $cheapest_products);
    }
}
