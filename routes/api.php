<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\TransporteController;
use App\Http\Controllers\Api\TransportsRouteController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ViajesController;
use Illuminate\Support\Facades\Route;

/** Login Route */
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/verify', [AuthController::class, 'verify'])->name('verify');
/** Register Route */
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::group(['middleware' => ['auth:sanctum']], function () {
    /** Logout Route */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'devices/', 'as' => 'devices.'], function ($router) {
        $router->post('/push', [DeviceController::class, 'push'])->name('push');
        $router->post('/updateKey', [DeviceController::class, 'updateKey'])->name('updateKey');
        $router->get('/keys', [DeviceController::class, 'getAllKeys'])->name('getAllKeys');
        $router->get('/keys/{id}', [DeviceController::class, 'getUserKeys'])->name('getUserKeys');
    });

    /** User Apis */
    Route::apiResource('users', UserController::class);

    /** Transports Apis */
    Route::apiResource('transports', TransporteController::class);
    Route::post('transports/assign_routes', [TransportsRouteController::class, 'assign_routes'])->name('assign_routes');

    /** Locations Apis */
    Route::apiResource('user-location', LocationController::class);
    Route::apiResource('user-location', LocationController::class);

    /** Viajes Apis */
    Route::apiResource('viajes', ViajesController::class);
    Route::post('viajes/updateStatus/{id}', [ViajesController::class, 'updateStatus'])->name('updateStatus');

    /** Routes Apis */
    Route::apiResource('routes', RouteController::class);
});
