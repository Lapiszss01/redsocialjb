<?php

namespace Database\Seeders;


use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topic::factory()->create([
            'name' => 'Deportes',
        ]);

        Topic::factory()->create([
            'name' => 'Videojuegos',
        ]);

        Topic::factory()->create([
            'name' => 'Noticias',
        ]);
    }
}
