<?php

namespace App\Livewire\Posts;

use App\Http\Requests\StoreOrUpdatePostRequest;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Topic;
use App\Rules\ForbiddenWordsRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PostForm extends Component
{
    use WithFileUploads;

    public $body;
    public $image;
    public $user;
    public $parentpost;
    public $parent_id ;
    public $post_id;
    public $published_at;
    protected $listeners = ['updatePublishedAt' => 'setPublishedAt', 'imageUploaded' => 'setImage'];
    public $imageBase64;
    public function mount($user = null)
    {
        $this->user = $user ?? Auth::user();
    }
    protected $rules = [
        'body' => 'required|min:1',
        'image' => 'nullable|max:2048',
        'published_at' => 'nullable',
    ];

    public function save()
    {

        $this->authorize('create', Post::class);
        $this->validateOnly('*');

        $rules = (new StoreOrUpdatePostRequest())->rules();
        if (is_string($rules['body'])) {
            $rules['body'] = explode('|', $rules['body']);
        }
        $rules['body'][] = new ForbiddenWordsRule();

        $validated = Validator::make(
            $this->only(['body', 'image', 'published_at']),
            $rules
        )->validate();

        $imagePath = $validated["image"] ? $validated["image"]->store('uploads', 'public') : null;

        if ($this->parentpost) {
            $this->parent_id = $this->parentpost->id;
        }

        if ($validated["published_at"]) {
            $validated["published_at"] = Carbon::parse($validated["published_at"])->format('Y-m-d H:i:s');
        }else{
            $validated["published_at"] = now();
        }

        $post = Post::updateOrCreate(
            ['id' => $this->post_id],
            [
                'body' => $validated["body"],
                'image_url' => $imagePath,
                'user_id' => auth()->id(),
                'parent_id' => $this->parent_id,
                'published_at' => $validated["published_at"],
            ]
        );

        preg_match_all('/#(\w+)/', $validated["body"], $matches);
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

        if ($this->parentpost) {
            event(new \App\Events\PostCommented($this->parentpost, $this->user));
            return null;
        } else{
            return $this->redirectRoute('post.show', $post->id);
        }


    }

    public function edit(Post $post)
    {
        $this->post_id = $post->id;
        $this->body = $post->body;
    }

    public function setPublishedAt($date)
    {
        $this->published_at = $date;
    }

    public function setImage($data)
    {
        $this->image = TemporaryUploadedFile::find($data['id']);
    }

    public function render()
    {
        return view('livewire.posts.post-form');
    }
}
