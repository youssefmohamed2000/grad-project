<?php

use App\Http\Controllers\Api\Users\AuthController;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Controllers\Api\Users\UserDetailsController;
use App\Http\Controllers\Api\Users\UserHistoryController;
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


    Route::middleware('auth.doctor')->group(function () {
        // users
        Route::apiResource('users', UserController::class);
        
        // user details
        Route::get('details/{user_id}', [UserDetailsController::class, 'show']);
        Route::post('details', [UserDetailsController::class, 'storeOrUpdate']);

        // user family history
        Route::get('history/{user_id}', [UserHistoryController::class, 'show']);
        Route::post('history', [UserHistoryController::class, 'storeOrUpdate']);
    });
});
