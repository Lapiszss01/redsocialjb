<?php

namespace Database\Seeders;


use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $topics = Topic::all();

        $users->each(function ($user) use ($topics) {
            $posts = Post::factory(2)->create(['user_id' => $user->id]);

            $posts->each(function ($post) use ($topics) {
                $post->topics()->attach(
                    $topics->random(rand(1, 3))->pluck('id')->toArray()
                );

                Post::factory(2)->create([
                    'parent_id' => $post->id,
                    'user_id' => $post->user_id,
                ]);
            });
        });
    }
}
