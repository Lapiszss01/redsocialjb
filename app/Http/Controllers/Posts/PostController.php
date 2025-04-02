<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::recent()->get();
        return view('welcome', compact('posts'));
    }

    public function show(Post $post)
    {
        $posts = Post::where('parent_id',$post->id)->orderBy('created_at', 'desc')->get();
        return view('posts.show', compact('post','posts'));
    }

}
