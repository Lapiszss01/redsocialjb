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
            $this->posts = Post::recentChilds($this->post_id)->get();
        }else {
            $this->posts =  Post::recent()->get();
        }
    }

    public function render()
    {
        return view('livewire.posts.post-list');
    }
}
