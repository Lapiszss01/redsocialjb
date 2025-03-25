<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostIndex extends Component
{
    use WithFileUploads;

    public $posts;
    public $post_id;
    public $childPosts;

    protected $listeners = ['postUpdated' => 'refreshPosts'];

    public function mount()
    {
        $this->refreshPosts();
    }

    public function refreshPosts()
    {
        if($this->childPosts){
            $this->posts = Post::where('parent_id', $this->post_id)->orderBy('created_at', 'desc')->get();
        }else {
            $this->posts = Post::where('parent_id', null)->orderBy('created_at', 'desc')->get();
        }
    }

    public function render()
    {
        return view('livewire.posts.post-list');
    }
}
