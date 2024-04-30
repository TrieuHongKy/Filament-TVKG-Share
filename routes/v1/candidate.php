<?php

use App\Http\Controllers\Api\V1\CandidateController;
use Illuminate\Support\Facades\Route;

Route::get('candidates', [CandidateController::class, 'index']);
Route::get('candidates/{id}', [CandidateController::class, 'show']);
Route::get('candidate/jobs/{id}', [CandidateController::class, 'showSavedJob']);
Route::post('candidates', [CandidateController::class, 'store']);
Route::put('candidates/{id}', [CandidateController::class, 'update']);
Route::delete('candidates/{id}', [CandidateController::class, 'destroy']);
