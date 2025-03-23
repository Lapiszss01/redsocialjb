<?php

namespace App\Http\Controllers\Posts;


use App\Events\PostDeletedByAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Jobs\SendPostDeletedEmail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function destroy(Post $post)
    {
        if (auth()->user()->role_id == 1) {
            event(new PostDeletedByAdmin($post));
            $post->delete();
            session()->flash('message', 'Post eliminado y usuario notificado.');
        }

        return redirect()->route('posts.index');
    }

    public function store(StorePostRequest $request, Post $post)
    {
        $post = auth()->user()->posts()->make($request->validated());
        $post->parent_id = null;
        $post->save();

        return view('posts.show', compact('post'));
    }

    public function storeResponse(StorePostRequest $request,Post $post)
    {
        $newPost = auth()->user()->posts()->make($request->validated());
        $newPost->parent_id = $post->id;
        $newPost->save();

        return view('posts.show', compact('post'));
    }

    public function upload(Request $request)
    {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('uploads', 'public');

                return response()->json(['path' => asset("storage/$path")]);
            }
            return response()->json(['error' => 'No file uploaded'], 400);
    }
}
