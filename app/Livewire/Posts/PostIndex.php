<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostIndex extends Component
{
    use WithFileUploads;

    public $posts;
    public $childPosts;

    protected $listeners = ['postUpdated' => 'refreshPosts'];

    public function mount()
    {
        if($this->childPosts){
            $this->posts = $this->childPosts;
        }else{
            $this->refreshPosts();
        }
    }

    public function refreshPosts()
    {
        $this->posts = Post::where('parent_id',null)->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        if($this->childPosts){
            return view('livewire.posts.post-child-list');
        }else{
            return view('livewire.posts.post-list');
        }

    }
}
