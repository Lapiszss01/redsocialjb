<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostItem extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function redirectToPost()
    {
        return redirect()->route('post.show', $this->post);
    }

    public function delete()
    {
        if (Auth::check() && (Auth::id() === $this->post->user_id || Auth::user()->role_id === 1)) {
            $this->post->delete();
            session()->flash('message', 'Post eliminado correctamente.');
            return redirect()->route('home');
        }
    }

    public function render()
    {
        return view('livewire.posts.post-item');
    }
}
