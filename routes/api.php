<?php

use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;


Route::middleware('api')->group(function () {

    Route::apiResource('users', UserController::class);
    Route::middleware('auth:sanctum')->get('/topics/most-used', [TopicController::class, 'mostUsedTopic']);
    Route::apiResource('topics', TopicController::class);


    Route::get('/posts', [PostController::class, 'index'])->name('api.posts.index');
    Route::middleware('auth:sanctum')->get('/posts/user/{userId}', [PostController::class, 'getByUser'])->name('api.posts.getByUser');

    Route::apiResource('posts', PostController::class)->except(['index']);
});
