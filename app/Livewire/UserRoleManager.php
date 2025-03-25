<?php

namespace App\Livewire;

use App\Jobs\DeleteInactiveUsers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserRoleManager extends Component
{
    public $users;
    public $message = '';
    public $roles;
    public $userRole = [];
    public $editingUser = false;
    public $creatingUser = false;
    public $userId;
    public $name;
    public $email;
    public $username;
    public $password;

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

    public function openUserCreating()
    {
        $this->creatingUser = true;
    }

    public function createUser()
    {

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => 1,
            'terms_accepted_at' => now(),
            'pdf_terms_accepted_at' => now(),
        ]);
        session()->flash('message', 'Usuario creado correctamente.');
        $this->creatingUser = false;
        $this->users = User::all();
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
        $user = User::find($userId);
        if ($user) {
            $user->posts()->delete();
            $user->delete();
            session()->flash('message', 'Usuario eliminado correctamente.');
            $this->users = User::all();
        }
    }

    public function deleteInactiveUsers()
    {
        dispatch(new DeleteInactiveUsers());
        $this->message = "Job ejecutado correctamente.";
    }

    public function deleteInactivePosts()
    {
        Artisan::call('posts:delete-inactive', ['days' => 30]);
        $this->message = "Borrados posts inactivos.";
    }

    public function render()
    {
        return view('livewire.userprofile.user-role-manager');
    }
}
