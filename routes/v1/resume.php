<?php

use App\Http\Controllers\Api\V1\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('resumes', [ResumeController::class, 'index']);
Route::get('resumes/{id}', [ResumeController::class, 'show']);
Route::post('resumes', [ResumeController::class, 'store']);
Route::put('resumes/{id}', [ResumeController::class, 'update']);
Route::delete('resumes/{id}', [ResumeController::class, 'destroy']);