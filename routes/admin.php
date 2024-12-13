<?php

use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::view('/', 'admin.index')->name('admin.dashboard');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    require __DIR__.'/adminAuth.php';
});
