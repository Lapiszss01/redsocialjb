<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        //$posts = Post::orderBy('created_at', 'desc')->get();
        $posts = Post::where('parent_id', 0)->orderBy('created_at', 'desc')->get();

        return view('welcome', compact('posts'));
    }

    public function show(Post $post)
    {
        $posts = Post::where('parent_id',$post->id)->orderBy('created_at', 'desc')->get();
        return view('posts.show', compact('post','posts'));
    }

    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->make($request->validated());
        $post->parent_id = 0;
        $post->save();

        return view('posts.show', compact('post'));
    }

    public function storeResponse(StorePostRequest $request,Post $post)
    {
        //dd($post->id);
        $newPost = auth()->user()->posts()->make($request->validated());
        $newPost->parent_id = $post->id;
        $newPost->save();

        return to_route('home');
    }

    public function like(Post $post)
    {
        $post->like(auth()->user());
        return to_route('home');
    }

}
