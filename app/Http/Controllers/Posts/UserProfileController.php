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
        $user = User::where('username', $username)->firstOrFail();
        //dd($user->name);
        return view('user-profile', compact('user'));
    }

}

