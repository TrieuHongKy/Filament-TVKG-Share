<?php

use App\Http\Controllers\Api\V1\ExperienceController;
use Illuminate\Support\Facades\Route;

Route::get('experiences', [ExperienceController::class, 'index']);
