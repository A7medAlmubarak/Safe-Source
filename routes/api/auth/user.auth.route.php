<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;

Route::group(['prefix' => 'user'], function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::put('/update', [UserController::class, 'update']);
        Route::post('/logout', [UserController::class, 'logout']);
    });
});
