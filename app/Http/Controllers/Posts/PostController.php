<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('welcome', compact('posts'));
    }

    public function show(Post $post)
    {
        //dd("Hola");
        return view('posts.show', compact('post'));
    }

    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->make($request->validated());
        $post->parent_id = 0;
        $post->save();

        return to_route('home');

    }

    public function like(Post $post)
    {
        $post->like(auth()->user());
        return to_route('home');
    }

}
