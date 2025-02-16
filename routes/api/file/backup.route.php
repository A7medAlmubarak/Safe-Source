<?php

use App\Http\Controllers\BackupFileController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'backup', 'middleware' => 'auth:api'], function () {
    Route::post('/file', [BackupFileController::class, 'getByFileId']);
    Route::post('/{id}', [BackupFileController::class, 'show']);

});

