<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use App\Models\Topic;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithFileUploads;

    public $body;
    public $image;
    public $parentpost;
    public $parent_id ;
    public $post_id;

    protected $rules = [
        'body' => 'required|min:1',
        'image' => 'nullable|max:2048',
    ];

    public function save()
    {
        $this->validateOnly('*');
        $this->validate();

        $imagePath = $this->image ? $this->image->store('uploads', 'public') : null;

        if ($this->parentpost) {
            $this->parent_id = $this->parentpost->id;
        }

        $post = Post::updateOrCreate(
            ['id' => $this->post_id],
            [
                'body' => $this->body,
                'image_url' => $imagePath,
                'user_id' => auth()->id(),
                'parent_id' => $this->parent_id,
            ]
        );

        preg_match_all('/#(\w+)/', $this->body, $matches);
        $topicIds = [];

        foreach ($matches[1] as $hashtag) {
            $topic = Topic::firstOrCreate([
                'name' => strtolower($hashtag),
            ]);
            $topicIds[] = $topic->id;
        }

        $post->topics()->sync($topicIds);
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
