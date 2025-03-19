<?php

namespace App\Livewire;

use App\Jobs\DeleteInactiveUsers;
use Livewire\Component;

class DeleteInactiveUsersComponent extends Component
{
    public $message = '';

    public function runJob()
    {
        dispatch(new DeleteInactiveUsers());
        $this->message = "Job ejecutado correctamente.";
    }

    public function render()
    {
        return view('livewire.delete-inactive-users-component');
    }
}
