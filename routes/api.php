<?php

use App\Http\Controllers\Api\Users\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User Routes
Route::group(['prefix' => 'users'], function () {
   
    // Auth Routes
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::get('user', [AuthController::class, 'currentUser'])->middleware('auth.user');
});

