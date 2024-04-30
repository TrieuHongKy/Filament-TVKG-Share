<?php

use App\Http\Controllers\Api\V1\WidgetController;
use Illuminate\Support\Facades\Route;

Route::get('widgets', [WidgetController::class, 'index']);
Route::get('widgets/{id}', [WidgetController::class, 'show']);
Route::get('widgets/key/{key}', [WidgetController::class, 'showByKey']);
Route::post('widgets', [WidgetController::class, 'store']);
Route::put('widgets/{id}', [WidgetController::class, 'update']);
Route::delete('widgets/{id}', [WidgetController::class, 'delete']);
