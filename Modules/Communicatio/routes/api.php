<?php

use Illuminate\Support\Facades\Route;
use Modules\Communicatio\Http\Controllers\CommunicatioController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('communicatios', CommunicatioController::class)->names('communicatio');
});
