<?php

use App\Http\Controllers\Frontend\Blog\BlogCommentController;
use App\Http\Controllers\Frontend\Blog\BlogController;
use App\Http\Controllers\Frontend\Blog\BlogSearchController;
use App\Http\Controllers\Frontend\Blog\BlogSubscriberController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home
Route::controller(HomeController::class)->name('frontend.')->group(function () {
    Route::get('/', 'index')->name('index');
});

// Products
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('frontend.product');
Route::post('/product/review', [ProductController::class, 'addReview'])->name('frontend.product.review');

// Shop
Route::get('/shop', [ShopController::class, 'index'])->name('frontend.shop');

// Wishlist
Route::middleware('auth')->group(function () {
    Route::post('/wishlist/{id}',[WishlistController::class, 'add'])->name('frontend.wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'get'])->name('frontend.wishlist.get');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'remove'])->name('frontend.wishlist.remove');
});

// Cart
Route::middleware('auth')->group(function () {
    Route::post('/cart/{id}',[CartController::class, 'add'])->name('frontend.cart.add');
    Route::get('/cart', [CartController::class, 'get'])->name('frontend.cart.get');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('frontend.cart.remove');
    Route::patch('/cart/{id}/update-quantity/{action}', [CartController::class, 'updateQuantity'])
        ->name('frontend.cart.updateQuantity');
    Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('frontend.cart.clear');
});

// Order
Route::middleware('auth')->group(function () {
    Route::post('/orders/store', [OrderController::class, 'store'])->name('frontend.orders.store'); // Place order
    Route::get('/orders', [OrderController::class, 'index'])->name('frontend.orders.index'); // List user orders
//    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('frontend.orders.show'); // View order details
    Route::get('/orders/invoice/download/{id}', [OrderController::class, 'orderInvoiceDownload'])->name('frontend.orders.invoice.download');
});

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('frontend.checkout.index')->middleware('auth');

// Payment

//Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment.success');
//Route::get('/payment-failed', [PaymentController::class, 'failed'])->name('payment.failed');

// Contact
Route::controller(ContactController::class)->name('frontend.')->group(function () {
    Route::get('/contact', 'index')->name('contact');
    Route::post('/contact/store', 'store')->name('contact.store');
});

// newsletter
Route::post('/newsletter', [SubscriberController::class, 'store'])->name('frontend.newsletter');

// search
Route::match(['get', 'post'], '/search', SearchController::class)->name('frontend.search');

// Blog
Route::resource('blogs', BlogController::class)->parameters([
    'blogs' => 'blog:slug',
]);
Route::get('/myBlogs', [BlogController::class, 'myBlogs'])->name('blogs.myBlogs')->middleware('auth');
Route::post('/blog-newsletter', [BlogSubscriberController::class, 'store'])->name('blogs.newsletter');
Route::post("/comment/store", [BlogCommentController::class, 'store'])->name("blogs.comments.store");
Route::get("/comment/{slug}", [BlogCommentController::class, 'index'])->name("blogs.comments");
Route::get("/category/{id}", [BlogController::class, 'category'])->name("blogs.category");
Route::match(['get', 'post'], '/blog/search', BlogSearchController::class)->name('blogs.search');

// User Profile
Route::middleware('auth')->prefix('frontend')->name('frontend.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/userAuth.php';
