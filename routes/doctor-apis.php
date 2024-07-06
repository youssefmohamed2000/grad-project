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
use App\Http\Controllers\Api\Doctors\GalleryController;
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
});

Route::middleware('auth.doctor')->group(function () {
    // roles
    Route::apiResource('roles', RoleController::class);
    Route::delete('roles', [RoleController::class, 'deleteMany']);

    // permissions
    Route::get('permissions', [PermissionController::class, 'index']);

    //doctors
    Route::apiResource('doctors', DoctorController::class);
    Route::delete('doctors', [DoctorController::class, 'deleteMany']);

    // sections
    Route::apiResource('sections', SectionController::class);
    Route::delete('sections', [SectionController::class, 'deleteMany']);

    // chronic diseases
    Route::apiResource('diseases', DiseasesController::class);
    Route::delete('diseases', [DiseasesController::class, 'deleteMany']);

    // complains
    Route::apiResource('complains', ComplainsController::class);
    Route::delete('complains', [ComplainsController::class, 'deleteMany']);

    // diagnoses
    Route::apiResource('diagnoses', DiagnosesController::class);
    Route::delete('diagnoses', [DiagnosesController::class, 'deleteMany']);

    // operations
    Route::apiResource('operations', OperationsController::class);
    Route::delete('operations', [OperationsController::class, 'deleteMany']);

    //galleries
    Route::apiResource('galleries', GalleryController::class)->except(['update', 'index', 'show']);
    Route::post('galleries/{id}', [GalleryController::class, 'update']);
    Route::delete('galleries', [GalleryController::class, 'deleteMany']);
});
