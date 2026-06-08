<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MaintenanceController;

Route::prefix('v1')
    ->middleware('iae.key')
    ->group(function () {

        Route::get('/maintenance', [MaintenanceController::class, 'index']);

        Route::get('/maintenance/{id}', [MaintenanceController::class, 'show']);

        Route::post('/maintenance', [MaintenanceController::class, 'store']);

});