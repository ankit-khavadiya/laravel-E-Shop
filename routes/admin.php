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

// Admin dashboard routes
Route::prefix('admin')->group(function () {

    // Admin login routes
    Route::middleware(['guest:admin'])->group(function () {
        Route::controller(AuthenticateController::class)->group(function () {
            Route::get('login','login')->name('admin.login');
            Route::post('post-login','postLogin')->name('admin.post-login');
        });
    });

    Route::middleware(['auth:admin'])->group(function () {

        // Admin home routes
        Route::controller(HomeController::class)->group(function () {
            Route::get('/', 'index')->name('admin.home');
            Route::get('admin-profile', 'adminProfile')->name('admin-profile');
            Route::post('post-admin-profile', 'adminProfileEdit')->name('post-admin-profile');
            Route::post('admin-profile-image', 'adminProfileImage')->name('admin-profile-image');
            Route::post('admin-change-password', 'adminChangePassword')->name('admin-change-password');
        });

        // Admin category tab routes
        Route::controller(CategoryController::class)->group(function () {
            Route::get('categories', 'index')->name('categories');
            Route::post('add-category', 'addCategory')->name('add-category');
            Route::post('get-category', 'getCategory')->name('get-category');
            Route::post('edit-category', 'editCategory')->name('edit-category');
            Route::post('post-edit-category', 'postEditCategory')->name('post-edit-category');
            Route::post('delete-category', 'deleteCategory')->name('delete-category');
        });

        // Admin product tab routes
        Route::controller(ProductController::class)->group(function () {
            Route::get('products', 'index')->name('products');
            Route::post('add-product', 'addProduct')->name('add-product');
            Route::post('get-product', 'getProducts')->name('get-product');
            Route::post('edit-product', 'editProduct')->name('edit-product');
            Route::post('post-edit-product', 'postEditProduct')->name('post-edit-product');
            Route::post('delete-product', 'deleteProduct')->name('delete-product');
        });

        // Admin customer tab routes
        Route::controller(CustomerController::class)->group(function () {
            Route::get('customers', 'index')->name('customers');
            Route::post('get-customers', 'getCustomers')->name('get-customers');
            Route::post('customer-details', 'customerDetails')->name('customer-details');
            Route::post('delete-customer', 'deleteCustomer')->name('delete-customer');
        });

        // Admin order tab routes
        Route::controller(OrderController::class)->group(function () {
            Route::get('orders', 'index')->name('orders');
            Route::post('get-orders', 'getOrders')->name('get-orders');
            Route::post('order-details', 'orderDetails')->name('admin-order-details');
            Route::post('update-order-status', 'updateStatus')->name('update-order-status');
            Route::post('delete-order', 'deleteOrder')->name('delete-order');
        });

        // Admin payment tab routes
        Route::controller(PaymentController::class)->group(function () {
            Route::get('payments', 'index')->name('payments');
            Route::post('get-payments', 'getPayments')->name('get-payments');
            Route::post('update-payment-status', 'updateStatus')->name('update-payment-status');
            Route::post('delete-payment', 'deletePayment')->name('delete-payment');
            Route::post('payment-details', 'paymentDetails')->name('payment-details');
        });

        // Admin setting tab routes
        Route::controller(SettingController::class)->group(function () {
            Route::get('settings', 'index')->name('settings');
            Route::post('settings/update',  'update')->name('settings.update');
        });
    });

    // Admin logout
    Route::get('logout', function (Request $request) {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    })->middleware('auth:admin')->name('logout');
});

