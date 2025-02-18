<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

Route::middleware('api')->group(function () {
    Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/user/{userId}', [PostController::class, 'getByUser']);
});
