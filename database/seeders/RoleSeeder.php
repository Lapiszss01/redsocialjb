<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrador', 'description' => 'User is allowed to manage and edit other users'],
            ['name' => 'user', 'display_name' => 'Usuario', 'description' => 'User is allowed to manage posts'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
