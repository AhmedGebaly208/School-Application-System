<?php

use Illuminate\Support\Facades\Route;
use Modules\Communicatio\Http\Controllers\CommunicatioController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('communicatios', CommunicatioController::class)->names('communicatio');
});
