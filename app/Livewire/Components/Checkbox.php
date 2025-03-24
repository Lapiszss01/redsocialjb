<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Checkbox extends Component
{
    public $checked = false;
    public $name;

    public function mount($checked = false, $name = 'checkbox')
    {
        $this->checked = $checked;
        $this->name = $name;
    }

    public function toggle()
    {
        $this->checked = !$this->checked;
        $this->emit('checkboxToggled', $this->checked);
    }

    public function render()
    {
        return view('livewire.components.checkbox-component');
    }
}
