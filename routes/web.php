<?php

use App\Http\Controllers\admin\AuthenticateController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {
        Route::controller(AuthenticateController::class)->group(function () {
            Route::get('login','login')->name('admin.login');
            Route::post('post-login','postLogin')->name('admin.post-login');
        });
    });

    Route::middleware(['auth:admin'])->group(function () {

        Route::controller(HomeController::class)->group(function () {
            Route::get('/', 'index')->name('admin.home');
            Route::get('admin-profile', 'adminProfile')->name('admin-profile');
            Route::post('post-admin-profile', 'adminProfileEdit')->name('post-admin-profile');
            Route::post('admin-profile-image', 'adminProfileImage')->name('admin-profile-image');
            Route::post('admin-change-password', 'adminChangePassword')->name('admin-change-password');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('categories', 'index')->name('categories');
            Route::post('add-category', 'addCategory')->name('add-category');
            Route::post('get-category', 'getCategory')->name('get-category');
            Route::post('edit-category', 'editCategory')->name('edit-category');
            Route::post('post-edit-category', 'postEditCategory')->name('post-edit-category');
            Route::post('delete-category', 'deleteCategory')->name('delete-category');
        });

        Route::controller(ProductController::class)->group(function () {
            Route::get('products', 'index')->name('products');
            Route::post('add-product', 'addProduct')->name('add-product');
            Route::post('get-product', 'getProducts')->name('get-product');
            Route::post('edit-product', 'editProduct')->name('edit-product');
            Route::post('post-edit-product', 'postEditProduct')->name('post-edit-product');
            Route::post('delete-product', 'deleteProduct')->name('delete-product');
        });

        Route::controller(CustomerController::class)->group(function () {
            Route::get('customers', 'index')->name('customers');
        });

        Route::controller(OrderController::class)->group(function () {
            Route::get('orders', 'index')->name('orders');
        });

        Route::controller(PaymentController::class)->group(function () {
            Route::get('payments', 'index')->name('payments');
        });

        Route::controller(SettingController::class)->group(function () {
            Route::get('settings', 'index')->name('settings');
            Route::post('settings/update',  'update')->name('settings.update');
        });
    });

    Route::get('logout', function (Request $request) {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    })->middleware('auth:admin')->name('logout');
});

Route::middleware(['guest:web'])->group(function () {
    Route::controller(\App\Http\Controllers\web\AuthenticateController::class)->group(function () {
        Route::get('login','login')->name('login');
        Route::get('register','register')->name('register');
        Route::post('post-login','postLogin')->name('post-login');
        Route::post('post-register','postRegister')->name('post-register');
        Route::post('google-login', 'googleLogin')->name('google-login');
    });
});

Route::middleware(['auth:web'])->group(function () {
    Route::controller(\App\Http\Controllers\web\HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home');
    });

    Route::controller(\App\Http\Controllers\web\UserProfileController::class)->group(function () {
        Route::get('user-profile', 'index')->name('user-profile');
        Route::get('stats', 'getStats')->name('stats');
        Route::get('recent-orders', 'getRecentOrders')->name('recent-orders');
        Route::get('all-orders', 'getAllOrders')->name('all-orders');
        Route::post('upload-image', 'uploadImage')->name('upload-image');
        Route::post('profile/update', 'updateProfile')->name('profile-update');
        Route::post('password/change', 'changePassword')->name('password-change');
        Route::delete('delete', 'deleteAccount')->name('delete');
    });

    Route::controller(\App\Http\Controllers\web\ShopController::class)->group(function () {
        Route::get('shop', 'index')->name('shop');
        Route::get('shop/filter', 'filter')->name('shop-filter');
        Route::get('product/{slug}', 'detail')->name('product-slug');
    });

    Route::controller(\App\Http\Controllers\web\CartController::class)->group(function () {
        Route::get('cart', 'index')->name('cart');
        Route::get('cartAdd', 'add')->name('cart-add');
        Route::get('cartUpdate', 'update')->name('cart-update');
        Route::get('cartDelete', 'delete')->name('cart-delete');
        Route::get('cartCount', 'count')->name('cart-count');
    });

    Route::controller(\App\Http\Controllers\web\WishlistController::class)->group(function () {
        Route::get('wishlist', 'index')->name('wishlist');
        Route::get('toggle', 'toggle')->name('toggle');
        Route::get('wishCount', 'count')->name('wishlist-count');
    });

    Route::get('logout', function (Request $request) {
        Auth::guard('web')->logout();
        return redirect()->route('home');
    })->middleware('auth:web')->name('user-logout');
});
