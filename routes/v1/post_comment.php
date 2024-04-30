<?php

use App\Http\Controllers\Api\V1\PostCommentController;
use Illuminate\Support\Facades\Route;

Route::get('post_comments', [PostCommentController::class, 'index']);
//Route::get('post_comments/{id}', [PostCommentController::class, 'show']);
Route::post('post_comments', [PostCommentController::class, 'store']);
Route::get('posts/{post_id}/comments', [PostCommentController::class, 'getCommentByPost']);
Route::get('post_comments/{id}', [PostCommentController::class, 'getDependentComment']);
//Route::put('post_comments/{id}', [PostCommentController::class, 'update']);
Route::delete('post_comments/{id}', [PostCommentController::class, 'destroy']);
