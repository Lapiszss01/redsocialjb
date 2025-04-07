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
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Get posts by user
     */
    public function getByUser($userId)
    {
        $posts = Post::where('user_id', $userId)->get();
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No posts found for this user'], 404);
        }
        return PostResource::collection($posts);
    }

    /**
     * Store a new post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'body' => 'required|string',
            'image_url' => 'nullable|url',
            'parent_id' => 'nullable|exists:posts,id',
            'published_at' => 'nullable|date',
        ]);

        $post = Post::create($validated);

        return new PostResource($post);
    }

    /**
     * Show a single post
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update an existing post
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'sometimes|required|string',
            'image_url' => 'nullable|url',
            'parent_id' => 'nullable|exists:posts,id',
            'published_at' => 'nullable|date',
        ]);

        $post->update($validated);

        return new PostResource($post);
    }

    /**
     * Delete a post
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully.']);
    }
}
