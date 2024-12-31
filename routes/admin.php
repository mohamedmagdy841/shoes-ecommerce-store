<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\GeneralSearchController;
use App\Http\Controllers\Admin\ManageAdminController;
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

//    Route::fallback(function(){
//        return response()->view('errors.404');
//    });

    // Home
    Route::get('/', [AdminHomeController::class, 'index'])->name('dashboard');

    // Profile
    Route::controller(AdminProfileController::class)->group(function () {
        Route::get('profile', 'edit')->name('profile.edit');
        Route::put('profile/{admin}', 'update')->name('profile.update');
    });

    // Users
    Route::controller(ManageUserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::delete('/users/{id}', 'destroy')->name('users.destroy');
        Route::get('users/status/{id}' ,'changeStatus')->name('users.changeStatus');
    });

    // Categories
    Route::resource('categories', ManageCategoryController::class)->except(['show', 'create', 'edit']);
    Route::get('categories/status/{id}' ,[ManageCategoryController::class, 'changeStatus'])->name('categories.changeStatus');

    // Products
    Route::resource('products', ManageProductController::class)->except('show');
    Route::get('products/status/{id}' ,[ManageProductController::class, 'changeStatus'])->name('products.changeStatus');

    // Orders
    Route::controller(ManageOrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::delete('/orders/{order}', 'destroy')->name('orders.destroy');
        Route::put('/orders/{order}/status' ,'updateStatus')->name('orders.updateStatus');
        Route::get('/orders/export' ,'export')->name('orders.export');
    });

    // Notifications
    Route::get('/notification/markasread', function () {
        Auth::guard('admin')->user()->notifications->markAsRead();
    })->name('notifications.read');
    Route::get('/notification/clear', function () {
        Auth::guard('admin')->user()->notifications()->delete();
    })->name('notifications.clear');

    // Settings
    Route::controller(ManageSettingController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings.index');
        Route::match(['put', 'patch'], '/settings/update', 'update')->name('settings.update');
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
