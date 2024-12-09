<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Pepe',
            'email' => 'pepe@mail.es',
            'password' => bcrypt('12345678'),
        ]);

        $users = User::factory(3)->create();
        $users->each(function ($user) {
            $user->posts()->saveMany(
                Post::factory(3)->make()
            );
        });
    }
}
