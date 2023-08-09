<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\TransporteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/** Login Route */
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify', [AuthController::class, 'verify'])->name('verify');
/** Register Route */
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::group(['middleware' => ['auth:sanctum']], function () {
    /** Logout Route */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /** User Apis */
    Route::apiResource('users', UserController::class);

    /** Transports Apis */
    Route::apiResource('transports', TransporteController::class);

    /** Locations Apis */
    Route::apiResource('user-location', LocationController::class);
});
