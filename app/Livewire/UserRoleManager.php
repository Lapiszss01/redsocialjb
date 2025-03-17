<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class UserRoleManager extends Component
{
    public $users;
    public $roles;
    public $userRole = [];
    public $editingUser = false;
    public $userId;
    public $name;
    public $email;

    public function mount()
    {
        $this->users = User::all();
        $this->roles = \App\Models\Role::all();
        foreach ($this->users as $user) {
            $this->userRole[$user->id] = $user->role_id;
        }
    }

    public function updateRole($userId, $roleId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->role_id = $roleId;
            $user->save();
            session()->flash('message', 'Rol actualizado correctamente.');
        }
    }

    public function editUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->editingUser = true;
        }
    }

    public function updateUser()
    {
        $user = User::find($this->userId);
        if ($user) {
            $user->name = $this->name;
            $user->email = $this->email;
            $user->save();
            $this->editingUser = false;
            $this->users = User::all();
            session()->flash('message', 'Usuario actualizado correctamente.');

        }
    }

    public function confirmDelete($userId)
    {
        $this->deleteUser($userId);
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->delete();
            session()->flash('message', 'Usuario eliminado correctamente.');
            $this->users = User::all();
        }
    }

    public function render()
    {
        return view('livewire.user-role-manager');
    }
}
