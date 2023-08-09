<?php

use App\Http\Controllers\Api\AuthController;
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
});

/*Route::middleware('auth:api')->group(function () {
    //check auth
    Route::get('/refresh-token', 'App\Http\Controllers\Api\AuthController@check_auth');

    //cerrar session usuario
    Route::delete('logout', 'App\Http\Controllers\Api\AuthController@logout');

    //Modelo Usuarios
    Route::resource('users', App\Http\Controllers\Api\UserController::class);

    //Usuarios Location
    Route::resource('user-location', App\Http\Controllers\Api\UsuariosLocationController::class);

    //usuarios transportes
    Route::resource('transports', App\Http\Controllers\Api\TransportesController::class);
});*/
