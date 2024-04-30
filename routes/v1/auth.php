<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])
     ->withoutMiddleware(['auth:api'])
     ->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [AuthController::class, 'profile']);

Route::post('/provider-callback', [AuthController::class, 'handleProviderCallback'])
     ->withoutMiddleware(['auth:api'])
     ->name('provider-callback');
