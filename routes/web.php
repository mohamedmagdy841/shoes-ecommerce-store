<?php

use App\Http\Controllers\Frontend\Blog\BlogCommentController;
use App\Http\Controllers\Frontend\Blog\BlogController;
use App\Http\Controllers\Frontend\Blog\BlogSubscriberController;
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

// newsletter
Route::post('/newsletter', [SubscriberController::class, 'store'])->name('frontend.newsletter');


// Blog
Route::resource('blogs', BlogController::class)->parameters([
    'blogs' => 'blog:slug',
]);
Route::get('/myBlogs', [BlogController::class, 'myBlogs'])->name('blogs.myBlogs')->middleware('auth');
Route::post('/blog-newsletter', [BlogSubscriberController::class, 'store'])->name('blogs.newsletter');
Route::post("/comment/store", [BlogCommentController::class, 'store'])->name("blogs.comments.store");
Route::get("/comment/{slug}", [BlogCommentController::class, 'index'])->name("blogs.comments");
Route::get("/category/{id}", [BlogController::class, 'category'])->name("blogs.category");

// ----------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/userAuth.php';
