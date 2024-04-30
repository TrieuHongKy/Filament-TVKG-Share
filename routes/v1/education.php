<?php

use App\Http\Controllers\Api\V1\EducationController;
use Illuminate\Support\Facades\Route;

Route::get('educations', [EducationController::class, 'index']);
Route::get('educations/{id}', [EducationController::class, 'show']);
Route::post('educations', [EducationController::class, 'store']);
Route::put('educations/{id}', [EducationController::class, 'update']);
Route::delete('educations/{id}', [EducationController::class, 'destroy']);
