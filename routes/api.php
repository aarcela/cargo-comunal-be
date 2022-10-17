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
});