<?php

use Illuminate\Support\Facades\Route;
use Modules\Behavior\Http\Controllers\BehaviorController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('behaviors', BehaviorController::class)->names('behavior');
});
