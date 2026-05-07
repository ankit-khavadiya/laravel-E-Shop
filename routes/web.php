<?php

use App\Http\Controllers\web\AuthenticateController;
use App\Http\Controllers\web\CartController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\ShopController;
use App\Http\Controllers\web\UserProfileController;
use App\Http\Controllers\web\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// User social login routes
Route::middleware(['guest:web'])->group(function () {
    Route::controller(AuthenticateController::class)->group(function () {
        Route::get('login','login')->name('login');
        Route::get('register','register')->name('register');
        Route::post('post-login','postLogin')->name('post-login');
        Route::post('post-register','registerPost')->name('post-register');
        Route::post('google-login', 'googleLogin')->name('google-login');
        Route::post('facebook-login', 'facebookLogin')->name('facebook-login');
    });
});

// User Home route
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

// Shop module routes
Route::controller(ShopController::class)->group(function () {
    Route::get('shop', 'index')->name('shop');
    Route::post('shop/filter', 'filter')->name('shop-filter');
    Route::get('product/{slug}', 'detail')->name('product-slug');
});

Route::middleware(['auth:web'])->group(function () {

    // User profile routes
    Route::controller(UserProfileController::class)->group(function () {
        Route::get('user-profile', 'index')->name('user-profile');
        Route::get('stats', 'getStats')->name('stats');
        Route::get('recent-orders', 'getRecentOrders')->name('recent-orders');
        Route::get('all-orders', 'getAllOrders')->name('all-orders');
        Route::post('user-profile-image', 'userProfileImage')->name('user-profile-image');
        Route::post('profile-update', 'updateProfile')->name('profile-update');
        Route::post('user-password-change', 'changePassword')->name('user-password-change');
        Route::delete('delete', 'deleteAccount')->name('delete');
    });

    // Cart module routes
    Route::controller(CartController::class)->group(function () {
        Route::get('cart', 'index')->name('cart');
        Route::post('cartAdd', 'add')->name('cart-add');
        Route::get('cartUpdate', 'update')->name('cart-update');
        Route::get('cartDelete', 'delete')->name('cart-delete');
        Route::get('cartCount', 'count')->name('cart-count');
    });

    // Wishlist module routes
    Route::controller(WishlistController::class)->group(function () {
        Route::get('wishlist', 'index')->name('wishlist');
        Route::post('toggle', 'toggle')->name('toggle');
        Route::get('wishlist-remove', 'remove')->name('wishlist-remove');
        Route::get('wishCount', 'count')->name('wishlist-count');
    });

    // User logout
    Route::get('logout', function (Request $request) {
        Auth::guard('web')->logout();
        return redirect()->route('home');
    })->middleware('auth:web')->name('logout');
});
