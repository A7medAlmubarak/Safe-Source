<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::group(['prefix' => 'file', 'middleware' => ['auth:api']], function () {
    Route::post('/', [FileController::class, 'create']);
    Route::post('/checkin', [FileController::class, 'checkIn']);
    Route::post('/checkin-multiple', [FileController::class, 'checkInMultiple']);
    Route::post('/checkout', [FileController::class, 'checkOut']);
    Route::post('/getChanges', [FileController::class, 'getChanges']);
    Route::post('/{id}', [FileController::class, 'update']);
    Route::post('/{id}', [FileController::class, 'update'])->middleware('ChangeAspectMiddleware');
});

