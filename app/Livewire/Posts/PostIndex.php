<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class PostIndex extends Component
{
    use WithFileUploads, WithPagination;

    public $post_id;
    public $childPosts = false;

    protected $paginationTheme = 'tailwind';

    protected $listeners = ['postUpdated' => '$refresh'];

    public function render()
    {
        $posts = $this->childPosts
            ? Post::recentChilds($this->post_id)->paginate(5)
            : Post::recent()->paginate(5);

        return view('livewire.posts.post-list', compact('posts'));
    }
}
