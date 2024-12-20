<?php

use App\Http\Controllers\Admin\ManageProductController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\ManageCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::view('/', 'admin.index')->name('dashboard');

    // user
    Route::controller(ManageUserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::delete('/users/{id}', 'destroy')->name('users.destroy');
        Route::get('users/status/{id}' ,'changeStatus')->name('users.changeStatus');
    });

    // category
    Route::resource('categories', ManageCategoryController::class)->except(['show', 'create', 'edit']);
    Route::get('categories/status/{id}' ,[ManageCategoryController::class, 'changeStatus'])->name('categories.changeStatus');

    // product
    Route::resource('products', ManageProductController::class)->except('show');
    Route::get('products/status/{id}' ,[ManageProductController::class, 'changeStatus'])->name('products.changeStatus');

    ##------------------------------------------------------- MARL ALL NOTIFICATIONS AS READ
    Route::get('/notification/markasread', function () {
        Auth::guard('admin')->user()->notifications->markAsRead();
    })->name('notifications.read');
    ##------------------------------------------------------- CLEAR ALL NOTIFICATIONS
    Route::get('/notification/clear', function () {
        Auth::guard('admin')->user()->notifications()->delete();
    })->name('notifications.clear');
});

Route::prefix('admin')->name('admin.')->group(function () {
    require __DIR__.'/adminAuth.php';
});