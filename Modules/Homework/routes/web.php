<?php

use Illuminate\Support\Facades\Route;
use Modules\Homework\Http\Controllers\HomeworkController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('homework', HomeworkController::class)->names('homework');
});
