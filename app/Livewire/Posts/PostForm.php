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
    public $parentpost;
    public $parent_id;
    public $post_id;

    protected $rules = [
        'body' => 'required|min:3',
        'image' => 'nullable|image|max:2048',
    ];

    public function save()
    {

        $this->validate();

        $imagePath = $this->image ? $this->image->store('uploads', 'public') : null;

        if($this->parentpost){
            $this->parent_id = $this->parentpost->id;
        }

        Post::updateOrCreate(
            ['id' => $this->post_id],
            ['body' => $this->body,
                'image_url' => $imagePath,
                'user_id' => auth()->id(),
                'parent_id' => $this->parent_id]

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
