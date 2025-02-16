<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeButton extends Component
{
    public $post;
    public $isLiked;
    public $likeCount;

    public function mount(Post $post)
    {
        $this->post = $post;
        $user = Auth::user();

        // Verificamos si el usuario ha dado like
        $this->isLiked = $user ? $this->post->isLiked($user) : false;
        $this->likeCount = $this->post->likes()->where('liked', true)->count();
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirige al login si no está autenticado
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
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
