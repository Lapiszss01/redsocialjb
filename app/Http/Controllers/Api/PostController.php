<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
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
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Get posts by user
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
    public function getByUser($userId)
    {
        $posts = Post::where('user_id', $userId)->get();
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No posts found for this user'], 404);
        }
        return PostResource::collection($posts);
    }
}
