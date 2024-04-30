<?php

use App\Http\Controllers\Api\V1\ApplyJobController;
use Illuminate\Support\Facades\Route;

Route::post('apply_job', [ApplyJobController::class, 'store']);

Route::post('already-applied', [ApplyJobController::class, 'alreadyApplied']);

Route::post('already-applied', [ApplyJobController::class, 'alreadyApplied']);
