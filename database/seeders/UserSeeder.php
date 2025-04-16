<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'User1',
            'email' => 'user1@mail.es',
            'password' => bcrypt('12345678'),
        ]);

        User::factory()->create([
            'name' => 'User2',
            'email' => 'user2@mail.es',
            'password' => bcrypt('12345678'),
            'role_id' => 2,
        ]);
    }
}
