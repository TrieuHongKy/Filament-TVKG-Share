<?php

use App\Http\Controllers\Api\V1\MajorController;
use Illuminate\Support\Facades\Route;

Route::get('/majors', [MajorController::class, 'index']);
