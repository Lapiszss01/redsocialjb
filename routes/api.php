<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

/**
 * @group Users
 * Get all users
 *
 * @response 200 {
 *   "data": [
 *     {
 *       "id": 1,
 *       "name": "User Name",
 *       "email": "user@example.com"
 *     }
 *   ]
 * }
 */
Route::middleware('api')->group(function () {
    Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index'])->name('api.users.index');

    /**
     * @group Posts
     * Get all posts
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Post title",
     *       "content": "Post content"
     *     }
     *   ]
     * }
     */
    Route::get('/posts', [PostController::class, 'index'])->name('api.posts.index');

    /**
     * @group Posts
     * Get posts by a user
     *
     * @urlParam userId int required The ID of the user. Example: 1
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "User's Post",
     *       "content": "Content of the post"
     *     }
     *   ]
     * }
     * @response 404 {
     *   "message": "No posts found for this user"
     * }
     */
    Route::get('/posts/user/{userId}', [PostController::class, 'getByUser'])->name('api.posts.getByUser');
});
