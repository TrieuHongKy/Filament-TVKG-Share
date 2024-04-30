<?php

use App\Http\Controllers\Api\V1\PostLikeController;
use Illuminate\Support\Facades\Route;

Route::get('post_likes', [PostLikeController::class, 'index']);
//Route::get('post_likes/{id}', [PostLikeController::class, 'show']);
Route::post('post_likes', [PostLikeController::class, 'store']);
Route::get('post_likes/like_check/{user_id}/{post_id}',
    [PostLikeController::class, 'checkLikePost']);
//Route::put('post_likes/{id}', [PostLikeController::class, 'update']);
Route::delete('post_likes/{id}', [PostLikeController::class, 'destroy']);
