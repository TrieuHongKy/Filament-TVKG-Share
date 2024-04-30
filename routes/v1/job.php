<?php

use App\Http\Controllers\Api\V1\JobController;
use Illuminate\Support\Facades\Route;

Route::get('jobs', [JobController::class, 'index']);
Route::get('jobs/{id}', [JobController::class, 'show']);
Route::get('jobs/category/{category:slug}', [JobController::class, 'getJobByCategory']);
// Route::post('post', [JobController::class, 'store']);
// Route::put('post/{id}', [JobControll
Route::get('jobs-search', [JobController::class, 'search']);
