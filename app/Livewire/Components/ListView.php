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
                $this->items = Topic::topTopics()->pluck('name');
                break;

            case 'users':
                $this->items = User::topUsersByPosts()->pluck('username');
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
