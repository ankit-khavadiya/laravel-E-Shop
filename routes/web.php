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
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('categories', 'index')->name('categories');
        });

        Route::controller(ProductController::class)->group(function () {
            Route::get('products', 'index')->name('products');
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
        });
    });

    Route::get('logout', function (Request $request) {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    })->middleware('auth:admin')->name('logout');
});



