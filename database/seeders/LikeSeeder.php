<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $posts = Post::all();

        $likesToGenerate = 10;

        for ($i = 0; $i < $likesToGenerate; $i++) {
            $user = $users->random();
            $post = $posts->random();

            DB::table('likes')->updateOrInsert(
                ['user_id' => $user->id, 'post_id' => $post->id],
                ['liked' => true]
            );
        }
    }
}
