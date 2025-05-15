<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserprofileRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function profile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $posts = Post::publishedMainPostsByUser($user->id)->get();
        return view('userprofile/user-profile', compact('user', 'posts'));
    }

    public function edit(User $user)
    {

        return view('userprofile/edit', compact('user'));
    }
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048',
        ]);

        $user = auth()->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('file')->store('profile-photos', 'public');
        $user->profile_photo = $path;
        $user->save();

        return response()->json(['path' => Storage::url($path)]);
    }

    public function update(UpdateUserprofileRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->save();

        return to_route('profile', $user->username)
            ->with('status', 'Post updated successfully');
    }

}

