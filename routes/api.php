<?php

use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use function Pest\Laravel\get;


Route::middleware(['api'])->group(function () {
    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('users', UserController::class)->except(['index']);
    });

    // Topics
    Route::get('/topics', [TopicController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/topics/most-used', [TopicController::class, 'mostUsedTopic']);
        Route::apiResource('topics', TopicController::class)->except(['index']);
    });


    // Posts
    Route::get('/posts', [PostController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/posts/user/{userId}', [PostController::class, 'getByUser'])->name('api.posts.getByUser');
        Route::apiResource('posts', PostController::class)->except(['index']);
    });
});
