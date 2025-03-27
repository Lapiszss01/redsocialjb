<?php

namespace App\Livewire\Components;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Collection;

class ListView extends Component
{
    public Collection $items;
    public string $title;
    public string $source;

    public function mount($title = '', $source = '')
    {
        $this->title = $title;
        $this->source = $source;
        $this->loadItems();
    }

    public function loadItems()
    {
        switch ($this->source) {
            case 'topics':
                $this->items = Topic::select('topics.name', DB::raw('COUNT(post_topic.post_id) as post_count'))
                                ->join('post_topic', 'topics.id', '=', 'post_topic.topic_id')
                                ->groupBy('topics.name')
                                ->orderByDesc('post_count')
                                ->limit(5)
                                ->pluck('name');
                break;
            case 'users':
                $this->items = User::select('users.username', DB::raw('COUNT(posts.id) as post_count'))
                                ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
                                ->groupBy('users.id', 'users.name')
                                ->orderByDesc('post_count')
                                ->limit(5)
                                ->pluck('username');
                break;
            default:
                $this->items = collect();
                break;
        }
    }

    public function render()
    {
        return view('livewire.components.list-view');
    }
}
