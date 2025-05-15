<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        return response()->json(['data' => User::all()]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {

        abort_if(! auth()->user()->tokenCan('Admin'), 403);

        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'biography' => 'nullable|string',
            'role_id' => 'nullable|integer',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json(['data' => $user], 201);
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['data' => $user]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        abort_if(! auth()->user()->tokenCan('Admin'), 403);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'username' => 'sometimes|string|unique:users,username,' . $user->id,
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6',
            'biography' => 'nullable|string',
            'role_id' => 'nullable|integer',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json(['data' => $user]);
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        abort_if(! auth()->user()->tokenCan('Admin'), 403);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
