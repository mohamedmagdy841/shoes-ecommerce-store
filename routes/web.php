<?php

use App\Http\Controllers\Frontend\Blog\BlogCommentController;
use App\Http\Controllers\Frontend\Blog\BlogController;
use App\Http\Controllers\Frontend\Blog\BlogSearchController;
use App\Http\Controllers\Frontend\Blog\BlogSubscriberController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CouponController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\SocialiteController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home
Route::controller(HomeController::class)->name('frontend.')->group(function () {
    Route::get('/', 'index')->name('index');
});

// Fallback
Route::fallback(function(){
    return response()->view('errors.404');
});

// Products
Route::controller(ProductController::class)->prefix('product')->name('frontend.')->group(function () {
    Route::get('/{slug}', [ProductController::class, 'show'])->name('product');
    Route::post('/review', [ProductController::class, 'addReview'])->name('product.review');
});

// Shop
Route::get('/shop', [ShopController::class, 'index'])->name('frontend.shop');

Route::middleware(['auth', 'checkUserStatus'])->group(function () {
    // Wishlist
    Route::controller(WishlistController::class)->prefix('wishlist')->name('frontend.wishlist.')->group(function () {
        Route::post('/{id}', 'add')->name('add');
        Route::get('/', 'get')->name('get');
        Route::delete('/{id}', 'remove')->name('remove');
    });

    // Cart
    Route::controller(CartController::class)->prefix('cart')->name('frontend.cart.')->group(function () {
        Route::post('/{id}',  'add')->name('add');
        Route::get('/',  'get')->name('get');
        Route::delete('/{id}',  'remove')->name('remove');
        Route::patch('/{id}/update-quantity/{action}',  'updateQuantity')
            ->name('updateQuantity');
        Route::get('/clear',  'clearCart')->name('clear');
    });

    // Coupon
    Route::get('/apply_coupon',  [CouponController::class, 'applyCoupon'])->name('frontend.coupon.apply_coupon'); // post didn't work
    Route::get('/cancel_coupon',  [CouponController::class, 'cancelCoupon'])->name('frontend.coupon.cancel_coupon');

    // Order
    Route::controller(OrderController::class)->prefix('orders')->name('frontend.orders.')->group(function () {
        Route::post('/cashOrder', 'cashOrder')->name('cash_order'); // Place order
        Route::get('/', 'index')->name('index'); // List user orders
        Route::get('/invoice/download/{id}', 'orderInvoiceDownload')->name('invoice.download');
        Route::post('/stripe_order', 'stripeOrder')->name('stripe_order');

    });

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('frontend.checkout.index');

    // User Profile
    Route::controller(ProfileController::class)->prefix('frontend/profile')->name('frontend.profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

// Payment
Route::middleware('auth')->group(function () {
    Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment-failed', [PaymentController::class, 'failed'])->name('payment.failed');
    Route::post('/payment/checkout', [PaymentController::class, 'paymentProcess'])->name('payment.process');
});

// Contact
Route::controller(ContactController::class)->prefix('contact')->name('frontend.')->group(function () {
    Route::get('/', 'index')->name('contact');
    Route::post('/store', 'store')->name('contact.store');
});

// newsletter
Route::post('/newsletter', [SubscriberController::class, 'store'])->name('frontend.newsletter');

// search
Route::match(['get', 'post'], '/search', SearchController::class)->name('frontend.search');

// Blog
Route::resource('blogs', BlogController::class)->parameters([
    'blogs' => 'blog:slug',
]);
Route::get("/category/{id}", [BlogController::class, 'category'])->name("blogs.category");
Route::get('/myBlogs', [BlogController::class, 'myBlogs'])->name('blogs.myBlogs')->middleware(['auth', 'checkUserStatus']);
Route::post('/blog-newsletter', [BlogSubscriberController::class, 'store'])->name('blogs.newsletter');
Route::post("/comment/store", [BlogCommentController::class, 'store'])->name("blogs.comments.store");
Route::get("/comment/{slug}", [BlogCommentController::class, 'index'])->name("blogs.comments");
Route::match(['get', 'post'], '/blog/search', BlogSearchController::class)->name('blogs.search');

require __DIR__.'/userAuth.php';

// Socialite OAuth
Route::prefix('socialite')->name('socialite.')->controller(SocialiteController::class)->group(function () {
    Route::get('{provider}/login', 'login')->name('login');
    Route::get('{provider}/redirect', 'redirect')->name('redirect');
});

Route::get('wait' , function(){
    return view('frontend.wait');
})->name('frontend.wait');

Route::get('dashboard' , function(){
    return view('welcome');
})->name('dashboard');
