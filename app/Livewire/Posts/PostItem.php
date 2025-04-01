<?php

namespace App\Livewire\Posts;

use App\Events\PostDeletedByAdmin;
use App\Events\PostLiked;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostItem extends Component
{
    public Post $post;
    public $isLiked;
    public $likeCount;
    public $childPosts;

    public function mount(Post $post)
    {
        $this->post = $post;

        $user = Auth::user();
        $this->isLiked = $user ? $this->post->isLiked($user) : false;
        $this->likeCount = $this->post->likes()->where('liked', true)->count();
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($this->isLiked) {
            $this->post->likes()->where('user_id', $user->id)->update(['liked' => false]);
            $this->isLiked = false;
            $this->likeCount--;
        } else {
            $this->post->likes()->updateOrCreate(
                ['user_id' => $user->id],
                ['liked' => true]
            );
            $this->isLiked = true;
            $this->likeCount++;
            event(new PostLiked($this->post, $user));

        }
    }

    public function redirectToPost($postId)
    {
        return redirect()->route('post.show', ['post' => $postId]);
    }

    public function delete()
    {
        if (auth()->user()->role_id == 1) {
            event(new PostDeletedByAdmin($this->post));
            session()->flash('message', 'Post eliminado y usuario notificado.');
        }
        $this->dispatch('postUpdated');
    }

    public function render()
    {
        if($this->childPosts) {
            return view('livewire.posts.post-child-item');
        } else{
            return view('livewire.posts.post-item');
        }

    }
}
