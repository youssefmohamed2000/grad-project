<?php

use App\Http\Controllers\Api\Doctors\DoctorAuthController;
use Illuminate\Support\Facades\Route;

// User Routes
Route::group(['prefix' => 'doctors'], function () {

    // Auth Routes
    Route::controller(DoctorAuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');

        Route::middleware('auth.doctor')->group(function () {
            Route::get('doctor', 'currentDoctor');
            Route::get('logout', 'logout');
        });
    });
});
