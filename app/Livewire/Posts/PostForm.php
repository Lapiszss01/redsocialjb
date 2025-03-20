<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;

    public $body;
    public $image;
    public $post_id;

    protected $rules = [
        'body' => 'required|min:3',
        'image' => 'nullable|image|max:2048',
    ];

    public function save()
    {

        $this->validate();

        $imagePath = $this->image ? $this->image->store('uploads', 'public') : null;

        Post::updateOrCreate(
            ['id' => $this->post_id],
            ['body' => $this->body, 'image_url' => $imagePath, 'user_id' => auth()->id()]
        );

        $this->reset(['body', 'image', 'post_id']);
        $this->dispatch('postUpdated');
    }

    public function edit(Post $post)
    {
        $this->post_id = $post->id;
        $this->body = $post->body;
    }

    public function render()
    {
        return view('livewire.posts.post-form');
    }
}
