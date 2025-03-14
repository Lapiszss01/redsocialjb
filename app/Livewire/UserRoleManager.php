<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class UserRoleManager extends Component
{
    public $users;
    public $roles;

    public function mount()
    {
        $this->users = User::all();
        $this->roles = Role::all();
    }

    public function updateRole($userId, $roleId)
    {
        $user = User::find($userId);
        $user->role_id = $roleId;
        $user->save();
    }

    public function render()
    {
        return view('livewire.user-role-manager');
    }
}
