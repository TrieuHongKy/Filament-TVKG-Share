<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::put('users/{id}', [UserController::class, 'update'])->name('update-user');
Route::get('users/{id}', [UserController::class, 'show'])->name('show-user');
Route::post('users/{id}', [UserController::class, 'updateImage'])->name('update-image');
