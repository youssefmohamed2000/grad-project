<?php

use App\Http\Controllers\Api\Doctor\PermissionController;
use App\Http\Controllers\Api\Doctors\AuthController;
use App\Http\Controllers\Api\Doctors\Doctorcontroller;
use App\Http\Controllers\Api\Doctors\RoleController;
use Illuminate\Support\Facades\Route;

// User Routes
Route::group(['prefix' => 'doctors'], function () {

    // Auth Routes
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');

        Route::middleware('auth.doctor')->group(function () {
            Route::get('doctor', 'currentDoctor');
            Route::post('logout', 'logout');
        });
    });

    Route::middleware('auth.doctor')->group(function () {
        // roles
        Route::apiResource('roles', RoleController::class)->except('show');

        // permissions
        Route::get('permissions', [PermissionController::class, 'index']);

        //doctors
        Route::apiResource('doctors', DoctorController::class);
    });
});
