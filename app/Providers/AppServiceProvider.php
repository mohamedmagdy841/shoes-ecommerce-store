<?php

namespace App\Providers;

use App\Services\CouponService;
use App\Services\CouponValidator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CouponValidator::class, function () {
            return new CouponValidator();
        });

        $this->app->bind(CouponService::class, function () {
            return new CouponService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Paginator::useBootstrapFive();
    }
}
