<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CheckSettingProvider extends ServiceProvider
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
        $getSetting = Setting::firstOr(function (){
            return Setting::create([
                'site_name' => 'Karma',
                'email' => 'karma@gmail.com',
                'phone' => '01234567891',
                'favicon' => 'default',
                'logo' => '/img/logo.png',
                'facebook' => 'https://www.facebook.com',
                'x' => 'https://x.com',
                'instagram' => 'https://www.instagram.com',
                'youtube' => 'https://www.youtube.com',
                'street' => '17th street',
                'city' => 'San Francisco',
                'country' => 'USA',
            ]);
        });

        // share categories
        $categories = Category::select('slug', 'name')->get();

        View::share([
            'getSetting' => $getSetting,
            'categories' => $categories,
        ]);
    }
}
