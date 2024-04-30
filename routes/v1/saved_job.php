<?php

use App\Http\Controllers\Api\V1\SavedJobController;
use Illuminate\Support\Facades\Route;

Route::get('saved_jobs', [SavedJobController::class, 'index']);
Route::post('saved_job', [SavedJobController::class, 'store']);
Route::get('saved_job/saved_check/{candidate_id}/{job_id}',
    [SavedJobController::class, 'checkSavedJob']);
Route::delete('saved_job/{id}', [SavedJobController::class, 'destroy']);
