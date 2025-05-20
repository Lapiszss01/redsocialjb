<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $posts = Post::all();

        $notificationsToCreate = 20;
        $relationTypes = ['like', 'comment'];

        for ($i = 0; $i < $notificationsToCreate; $i++) {
            $post = $posts->random();
            $actor = $users->where('id', '!=', $post->user_id)->random();
            $relationType = $relationTypes[array_rand($relationTypes)];

            $notification = Notification::create([
                'post_id' => $post->id,
                'actor_id' => $actor->id,
            ]);

            $notification->users()->attach($post->user_id, [
                'relation_type' => $relationType,
                'is_read' => false,
            ]);
        }
    }
}
