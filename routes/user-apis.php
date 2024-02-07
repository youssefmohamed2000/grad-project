<?php

use App\Http\Controllers\Api\Users\AuthController;
use Illuminate\Support\Facades\Route;

// User Routes
Route::group(['prefix' => 'users'], function () {

    // Auth Routes
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');

        Route::middleware('auth.user')->group(function () {
            Route::get('user', 'currentUser');
            Route::post('logout', 'logout');
        });
    });
});
