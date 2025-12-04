<?php

use Illuminate\Support\Facades\Route;
use Modules\Counseling\Http\Controllers\CounselingController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('counselings', CounselingController::class)->names('counseling');
});
