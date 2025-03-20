<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostList extends Component
{
    use WithFileUploads;

    public $posts;

    protected $listeners = ['postUpdated' => 'refreshPosts'];

    public function mount()
    {
        $this->refreshPosts();
    }

    public function refreshPosts()
    {
        $this->posts = Post::latest()->get();
    }

    public function render()
    {
        return view('livewire.posts.post-list');
    }
}
