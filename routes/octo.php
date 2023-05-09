<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['auth', 'verified']], function () {
    });
});
