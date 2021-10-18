<?php

use Octo\Octo;
use Illuminate\Support\Facades\Route;
use Octo\Http\Controllers\NotificationsController;

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth', 'verified']], function () {
        // Notifications
        if (Octo::hasNotificationsFeatures()) {
            Route::get('/user/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
        }
    });
});
