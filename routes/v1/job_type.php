<?php

use App\Http\Controllers\Api\V1\JobTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/job-types', [JobTypeController::class, 'index']);
