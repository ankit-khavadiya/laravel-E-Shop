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

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::middleware(['auth:web'])->group(function () {

    Route::controller(UserProfileController::class)->group(function () {
        Route::get('user-profile', 'index')->name('user-profile');
        Route::get('stats', 'getStats')->name('stats');
        Route::get('recent-orders', 'getRecentOrders')->name('recent-orders');
        Route::get('all-orders', 'getAllOrders')->name('all-orders');
        Route::post('user-profile-image', 'userProfileImage')->name('user-profile-image');
        Route::post('profile/update', 'updateProfile')->name('profile-update');
        Route::post('password/change', 'changePassword')->name('password-change');
        Route::delete('delete', 'deleteAccount')->name('delete');
    });

    Route::controller(ShopController::class)->group(function () {
        Route::get('shop', 'index')->name('shop');
        Route::get('shop/filter', 'filter')->name('shop-filter');
        Route::get('product/{slug}', 'detail')->name('product-slug');
    });

    Route::controller(CartController::class)->group(function () {
        Route::get('cart', 'index')->name('cart');
        Route::get('cartAdd', 'add')->name('cart-add');
        Route::get('cartUpdate', 'update')->name('cart-update');
        Route::get('cartDelete', 'delete')->name('cart-delete');
        Route::get('cartCount', 'count')->name('cart-count');
    });

    Route::controller(WishlistController::class)->group(function () {
        Route::get('wishlist', 'index')->name('wishlist');
        Route::get('toggle', 'toggle')->name('toggle');
        Route::get('wishCount', 'count')->name('wishlist-count');
    });

    Route::get('logout', function (Request $request) {
        Auth::guard('web')->logout();
        return redirect()->route('home');
    })->middleware('auth:web')->name('logout');
});
