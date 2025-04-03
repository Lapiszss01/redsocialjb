<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserprofileRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function profile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $posts = Post::byUser($user->id)->get();
        return view('userprofile/user-profile', compact('user', 'posts'));
    }

    public function edit(User $user)
    {

        return view('userprofile/edit', compact('user'));
    }

    public function update(UpdateUserprofileRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->save();

        return to_route('profile', $user->username)
            ->with('status', 'Post updated successfully');
    }

}

