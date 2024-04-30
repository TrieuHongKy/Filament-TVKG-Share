<?php

use App\Http\Controllers\Api\V1\LanguageController;
use Illuminate\Support\Facades\Route;

Route::get('languages', [LanguageController::class, 'index']);
Route::get('languages/{id}', [LanguageController::class, 'show']);
Route::post('languages', [LanguageController::class, 'store']);
Route::put('languages/{id}', [LanguageController::class, 'update']);
Route::delete('languages/{id}', [LanguageController::class, 'destroy']);