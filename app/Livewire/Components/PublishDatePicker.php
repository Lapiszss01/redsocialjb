<?php

namespace App\Livewire\Components;

use Livewire\Component;

class PublishDatePicker extends Component
{
    public $published_at;

    public function emitPublishedAt()
    {
        $this->dispatch('updatePublishedAt', $this->published_at);
    }

    public function render()
    {
        return view('livewire.components.publish-date-picker');
    }
}
