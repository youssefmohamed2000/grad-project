<?php

use App\Http\Controllers\Api\Doctors\AuthController;
use Illuminate\Support\Facades\Route;

// User Routes
Route::group(['prefix' => 'doctors'], function () {

    // Auth Routes
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');

        Route::middleware('auth.doctor')->group(function () {
            Route::get('doctor', 'currentDoctor');
            Route::post('logout', 'logout');
        });
    });
});
