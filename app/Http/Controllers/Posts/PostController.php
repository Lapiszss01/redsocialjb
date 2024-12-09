<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('welcome', compact('posts'));
    }

    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->make($request->validated());
        $post->save();

        return to_route('home');

    }

    public function like(Post $post)
    {
        $post->like(auth()->user());
        return to_route('home');
    }

}
