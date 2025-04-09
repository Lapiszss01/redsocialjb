<?php

namespace App\Livewire\Components;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class SelectComponent extends Component
{
    public $userId;
    public $roleId;
    public $roles;

    public function mount($userId, $roleId)
    {
        $this->userId = $userId;
        $this->roleId = $roleId;
        $this->roles = Role::all();
    }

    public function updatedRoleId($value)
    {
        $this->updateRole($value);
    }

    public function updateRole($value)
    {

        $this->authorize('assignRole', User::class);


        $user = User::find($this->userId);
        if ($user) {
            $user->role_id = $value;
            $user->save();

            $this->roleId = $value;
        }
    }

    public function render()
    {
        return view('livewire.components.select-component');
    }

}
