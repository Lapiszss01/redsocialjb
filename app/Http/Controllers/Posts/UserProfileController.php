<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function profile($username)
    {
        //dd($user->name);
        $user = User::where('username', $username)->firstOrFail();
        $posts = $user->posts;
        return view('userprofile/user-profile', compact('user', 'posts'));
    }

}

