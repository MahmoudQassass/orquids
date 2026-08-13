<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StoreController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SpinWheelController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\StoreAuthController;
use App\Http\Controllers\AccountController;



Route::post(
    '/products/availability/{country}',
    [StoreController::class, 'checkAvailability']
)->name('store.products.availability');

/*
|--------------------------------------------------------------------------
| Customer Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get(
        '/login',
        [StoreAuthController::class, 'showLogin']
    )->name('store.login');

    Route::post(
        '/login',
        [StoreAuthController::class, 'login']
    )->name('store.login.submit');


    Route::get(
        '/register',
        [StoreAuthController::class, 'showRegister']
    )->name('store.register');

    Route::post(
        '/register',
        [StoreAuthController::class, 'register']
    )->name('store.register.submit');

});


Route::post(
    '/logout',
    [StoreAuthController::class, 'logout']
)
->middleware('auth')
->name('store.logout');


/*
|--------------------------------------------------------------------------
| Customer Account
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('account')->group(function () {

    Route::get(
        '/',
        [AccountController::class, 'index']
    )->name('store.account');


    Route::put(
        '/profile',
        [AccountController::class, 'update']
    )->name('store.account.profile');


    Route::put(
        '/marketing-consent',
        [AccountController::class, 'updateMarketingConsent']
    )->name('store.account.marketing');

});

Route::post(
    '/checkout/apply-coupon',
    [StoreController::class, 'applyCoupon']
)->name('store.applyCoupon');

Route::post(
    '/checkout/remove-coupon',
    [StoreController::class, 'removeCoupon']
)->name('store.removeCoupon');


/*
|--------------------------------------------------------------------------
| Spin Wheel
|--------------------------------------------------------------------------
*/

Route::post(
    '/spin-wheel/spin',
    [SpinWheelController::class, 'spin']
)->name('spin-wheel.spin');

/*
|--------------------------------------------------------------------------
| Store
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', [
    StoreController::class,
    'index'
])->name('store.index');


/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

Route::get('/products/{slug}', [
    StoreController::class,
    'showProduct'
])->name('products.show');


/*
|--------------------------------------------------------------------------
| Buy Now
|--------------------------------------------------------------------------
*/

Route::post('/buy-now', [
    StoreController::class,
    'buyNow'
])->name('store.buyNow');


/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::get('/cart', [
    CartController::class,
    'index'
])->name('cart.index');

Route::post('/cart/add/{product}', [
    CartController::class,
    'add'
])->name('cart.add');

Route::patch('/cart/update/{product}', [
    CartController::class,
    'update'
])->name('cart.update');

Route::delete('/cart/remove/{product}', [
    CartController::class,
    'remove'
])->name('cart.remove');

Route::delete('/cart/clear', [
    CartController::class,
    'clear'
])->name('cart.clear');


/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [
    StoreController::class,
    'showCheckout'
])->name('store.checkout');

Route::post('/checkout', [
    StoreController::class,
    'checkout'
])->name('store.processCheckout');


/*
|--------------------------------------------------------------------------
| PayTabs Payment
|--------------------------------------------------------------------------
*/

Route::get('/payment/pay/{order}', [
    PaymentController::class,
    'pay'
])->name('payment.pay');


/*
|--------------------------------------------------------------------------
| PayTabs Callback
|
| PayTabs -> Server
|--------------------------------------------------------------------------
*/

Route::post('/payment/callback', [
    PaymentController::class,
    'callback'
])->name('payment.callback');


/*
|--------------------------------------------------------------------------
| Payment Result
|
| Customer -> Website
|--------------------------------------------------------------------------
*/

Route::match(['GET', 'POST'], '/payment/result/{token}', [
    PaymentController::class,
    'result'
])->name('payment.result');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Authentication
        |--------------------------------------------------------------------------
        */

        Route::get('/login', [
            AuthController::class,
            'showLogin'
        ])->name('login');

        Route::post('/login', [
            AuthController::class,
            'login'
        ])->name('login.submit');

        Route::post('/logout', [
            AuthController::class,
            'logout'
        ])->name('logout');


        /*
        |--------------------------------------------------------------------------
        | Protected Admin
        |--------------------------------------------------------------------------
        */

        Route::middleware('admin')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/', [
                DashboardController::class,
                'index'
            ])->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | Products
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'products',
                ProductController::class
            );


            /*
            |--------------------------------------------------------------------------
            | Orders
            |--------------------------------------------------------------------------
            */

            Route::get('/orders', [
                OrderController::class,
                'index'
            ])->name('orders.index');

            Route::get('/orders/{order}', [
                OrderController::class,
                'show'
            ])->name('orders.show');


            Route::resource(
                'customers',
                CustomerController::class
            );

            Route::patch(
                '/orders/{order}/status',
                [OrderController::class, 'updateStatus']
            )->name('orders.status');


            Route::resource(
                'coupons',
                CouponController::class
            )->except([
                'show'
            ]);

            Route::post(
                'coupons/generate',
                [CouponController::class, 'generate']
            )->name('coupons.generate');

        });

    });
