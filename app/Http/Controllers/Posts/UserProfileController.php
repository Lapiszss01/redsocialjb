<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function profile(User $user)
    {
        $posts = Post::all();
        return view('welcome', compact('posts'));
    }

}

