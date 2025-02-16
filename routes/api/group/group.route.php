<?php

use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'group', 'middleware' => 'auth:api'], function () {
    Route::get('/', [GroupController::class, 'index']);
    Route::post('/', [GroupController::class, 'store']);
    Route::get('/{id}', [GroupController::class, 'show']);
    Route::put('/{id}', [GroupController::class, 'update']);
    Route::delete('/{id}', [GroupController::class, 'destroy']);
    Route::get('/{id}/file/{file_id}/share', [GroupController::class, 'share']);
    Route::get('/{id}/user/{userId}', [GroupController::class, 'addUser']);
    Route::delete('/{id}/user/{userId}', [GroupController::class, 'removeUser']);

    Route::get('/{id}/files', [GroupController::class, 'getFileForGroup']);
    Route::get('/{id}/users', [GroupController::class, 'getUserForGroup']);


});
