<?php

use App\Http\Controllers\Api\Users\AuthController;
use App\Http\Controllers\Api\Users\UserController;
use Illuminate\Support\Facades\Route;

// User Routes
Route::group(['prefix' => 'users'], function () {

    // Auth Routes
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');

        Route::middleware('auth.user')->group(function () {
            Route::get('user', 'currentUser');
            Route::post('logout', 'logout');
        });
    });

    Route::middleware('auth.user')->group(function () {
        Route::apiResource('users', UserController::class);
    });
});
