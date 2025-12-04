<?php

use Illuminate\Support\Facades\Route;
use Modules\Counseling\Http\Controllers\CounselingController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('counselings', CounselingController::class)->names('counseling');
});
