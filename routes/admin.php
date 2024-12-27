<?php

use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\ManageProductController;
use App\Http\Controllers\Admin\ManageRoleController;
use App\Http\Controllers\Admin\ManageSettingController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\ManageCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::view('/', 'admin.index')->name('dashboard');

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
    // Roles
    Route::resource('roles', ManageRoleController::class)->except(['show']);
});

Route::prefix('admin')->name('admin.')->group(function () {
    require __DIR__.'/adminAuth.php';
});
