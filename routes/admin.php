<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\GeneralSearchController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\ManageCouponController;
use App\Http\Controllers\Admin\ManageOrderController;
use App\Http\Controllers\Admin\ManageProductController;
use App\Http\Controllers\Admin\ManageRoleController;
use App\Http\Controllers\Admin\ManageSettingController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\ManageCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale().'/admin',
        'as' =>'admin.',
        'middleware' => [ 'admin', 'checkAdminStatus', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    function () {

    // Home
    Route::get('/', [AdminHomeController::class, 'index'])->name('dashboard');

    // Profile
    Route::controller(AdminProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::put('/{admin}', 'update')->name('update');
    });

    // Users
    Route::controller(ManageUserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/status/{id}' ,'changeStatus')->name('changeStatus');
    });

    // Categories
    Route::resource('categories', ManageCategoryController::class)->except(['show', 'create', 'edit']);
    Route::get('categories/status/{id}' ,[ManageCategoryController::class, 'changeStatus'])->name('categories.changeStatus');

    // Products
    Route::resource('products', ManageProductController::class)->except('show');
    Route::get('products/status/{id}' ,[ManageProductController::class, 'changeStatus'])->name('products.changeStatus');

    // Coupons
    Route::controller(ManageCouponController::class)->prefix('coupons')->name('coupons.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/{coupon}/edit', 'edit')->name('edit');
        Route::post('/', 'store')->name('store');
        Route::delete('/{coupon}', 'destroy')->name('destroy');
        Route::patch('/{coupon}', 'update')->name('update');
    });

    // Orders
    Route::controller(ManageOrderController::class)->prefix('orders')->name('orders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/{order}', 'destroy')->name('destroy');
        Route::put('/{order}/status' ,'updateStatus')->name('updateStatus');
        Route::get('/export' ,'export')->name('export');
    });

    // Notifications
    Route::controller(ManageUserController::class)->prefix('notification')->name('notifications.')->group(function () {
        Route::get('/markasread', function () {
            Auth::guard('admin')->user()->notifications->markAsRead();
        })->name('read');

        Route::get('/clear', function () {
            Auth::guard('admin')->user()->notifications()->delete();
        })->name('clear');
    });

    // Settings
    Route::controller(ManageSettingController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::match(['put', 'patch'], '/update', 'update')->name('update');
    });

    // Admins
    Route::resource('admins', ManageAdminController::class)->except(['show']);
    Route::get('admins/status/{id}' ,[ManageAdminController::class, 'changeStatus'])
        ->name('admins.changeStatus');

    // Roles
    Route::resource('roles', ManageRoleController::class)->except(['show']);

    // General Search
    Route::get('search', [GeneralSearchController::class , 'search'])->name('search');
});

Route::prefix('admin')->name('admin.')->group(function () {
    require __DIR__.'/adminAuth.php';
});
