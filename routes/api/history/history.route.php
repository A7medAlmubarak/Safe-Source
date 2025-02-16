<?php
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'history', 'middleware' => 'auth:api'], function () {
    Route::get('/', [HistoryController::class, 'index']);
    Route::get('/file/{fileId}', [HistoryController::class, 'getHistoryForFile']);
    Route::get('/file/{fileId}/download', [HistoryController::class, 'downloadHistoryForFile']);
    Route::get('/user/{userId}', [HistoryController::class, 'getHistoryForUser']);
});
