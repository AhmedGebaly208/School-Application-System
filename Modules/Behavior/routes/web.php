<?php

use Illuminate\Support\Facades\Route;
use Modules\Behavior\Http\Controllers\BehaviorController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('behaviors', BehaviorController::class)->names('behavior');
});
