<?php

use App\Http\Controllers\Api\Doctors\ComplainsController;
use App\Http\Controllers\Api\Doctors\DiagnosesController;
use App\Http\Controllers\Api\Doctors\OperationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Doctors\AuthController;
use App\Http\Controllers\Api\Doctors\RoleController;
use App\Http\Controllers\Api\Doctors\DoctorController;
use App\Http\Controllers\Api\Doctors\SectionController;
use App\Http\Controllers\Api\Doctors\DiseasesController;
use App\Http\Controllers\Api\Doctors\PermissionController;

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

        // sections
        Route::apiResource('sections', SectionController::class)->except('show');

        // chronic diseases
        Route::apiResource('diseases', DiseasesController::class)->except('show');
        
        // complains
        Route::apiResource('complains', ComplainsController::class);
        
        // diagnoses
        Route::apiResource('diagnoses', DiagnosesController::class);
        
        // operations
        Route::apiResource('operations', OperationsController::class);
    });
});
