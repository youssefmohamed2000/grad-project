<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Doctors\GalleryController;

require __DIR__ . '/user-apis.php';

require __DIR__ . '/doctor-apis.php';

Route::apiResource('galleries', GalleryController::class)->only(['index', 'show']);
