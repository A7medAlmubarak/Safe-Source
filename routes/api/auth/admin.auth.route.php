<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::post('register', [AdminController::class, 'register']);
    Route::post('login', [AdminController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/history/file/{fileId}', [AdminController::class, 'getHistoryForFile']);
    });

});
