<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home
Route::controller(HomeController::class)->name('frontend.')->group(function () {
    Route::get('/', 'index')->name('index');
});

// Contact
Route::controller(ContactController::class)->name('frontend.')->group(function () {
    Route::get('/contact', 'index')->name('contact');
    Route::post('/contact/store', 'store')->name('contact.store');
});

Route::post('/newsletter', [SubscriberController::class, 'store'])->name('frontend.newsletter');

// ----------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
