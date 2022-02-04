<?php

use Illuminate\Support\Facades\Route;
use Octo\Billing\Http\Controllers\BillingController;
use Octo\Billing\Http\Controllers\InvoiceController;
use Octo\Billing\Http\Controllers\PaymentMethodController;
use Octo\Billing\Http\Controllers\SubscriptionController;
use Octo\Http\Controllers\NotificationsController;

Route::group(['middleware' => ['web']], function () {
    // We redirect filament login to jetstream login
    Route::redirect(config('filament.path') . '/login', '/login');

    Route::group(['middleware' => ['auth', 'verified']], function () {
        // Notifications
        Route::get('/user/notifications', [NotificationsController::class, 'index'])->name('notifications');

        // Billing
        Route::group([
            'prefix' => 'billing',
            'as' => 'billing-portal.',
        ], function () {
            if (class_exists(StripeCashier::class)) {
                Route::post(
                    '/stripe/webhook',
                    [
                        \Octo\Billing\Http\Controllers\StripeWebhook::class,
                        'handleWebhook',
                    ]
                )->name('stripe.webhook');
            }

            Route::get('/', [BillingController::class, 'dashboard'])->name('dashboard');
            Route::get('/portal', [BillingController::class, 'portal'])->name('portal');

            Route::get('/subscription/subscribe/{plan}', [SubscriptionController::class, 'redirectWithSubscribeIntent'])->name('subscription.plan-subscribe');

            Route::resource('invoice', InvoiceController::class)->only('index');
            Route::resource('payment-method', PaymentMethodController::class)->only('index', 'create', 'store');
            Route::resource('subscription', \Octo\Billing\Http\Controllers\SubscriptionController::class)->only('index');
        });

        // System
        Route::group(['middleware' => ['system.dashboard']], function () {
            Route::get('/system/users', [\Octo\Http\Controllers\System\UsersController::class, 'index'])->name('system.users.index');
            Route::get('/system/site', [\Octo\Http\Controllers\System\SiteController::class, 'index'])->name('system.site');
            Route::prefix('/system/dashboard')->group(function () {
                Route::get('/', [\Octo\Http\Controllers\System\DashboardController::class, 'index'])->name('system.dashboard');
            });
        });
    });
});
