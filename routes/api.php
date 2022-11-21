<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Login
Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');

//Register
Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');

Route::middleware('auth:api')->group(function() {
    //check auth
    Route::get('/refresh-token', 'App\Http\Controllers\Api\AuthController@check_auth');

    //cerrar session usuario
    Route::delete('logout', 'App\Http\Controllers\Api\AuthController@logout');

    //Modelo Usuarios
    Route::resource('users', App\Http\Controllers\Api\UsuariosController::class);

    //Usuarios Location
    Route::resource('user-location', App\Http\Controllers\Api\UsuariosLocationController::class);

    //usuarios transportes 
    Route::resource('transports', App\Http\Controllers\Api\TransportesController::class);
});