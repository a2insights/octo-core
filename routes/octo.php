<?php

use Illuminate\Support\Facades\Route;
use Octo\Billing\Http\Controllers\BillingController;
use Octo\Billing\Http\Controllers\InvoiceController;
use Octo\Billing\Http\Controllers\PaymentMethodController;
use Octo\Billing\Http\Controllers\BillingWebhook;
use Octo\Billing\Http\Controllers\SubscriptionController;
use Octo\Billing\Http\Middleware\Authorize;
use Octo\Common\Http\NotificationsController;
use Octo\System\Http\Controllers\DashboardController;
use Octo\System\Http\Controllers\SiteController;
use Octo\System\Http\Controllers\ThemesController;
use Octo\System\Http\Controllers\UsersController;

Route::group(['middleware' => ['web']], function () {

    Route::group(['middleware' => ['auth', 'verified']], function () {

    });
});
