<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $likes = Like::all();
        foreach ($likes as $like) {
            $post = Post::find($like->post_id);
            if (!$post || $like->user_id === $post->user_id) {
                continue;
            }

            $notification = Notification::create([
                'post_id' => $post->id,
                'actor_id' => $like->user_id,
            ]);

            $notification->users()->attach($post->user_id, [
                'relation_type' => 'like',
                'is_read' => false,
            ]);
        }

        $comments = Post::where('parent_id', '!=', 0)->get();
        foreach ($comments as $comment) {
            $parentPost = Post::find($comment->parent_id);
            if (!$parentPost || $comment->user_id === $parentPost->user_id) {
                continue;
            }

            $notification = Notification::create([
                'post_id' => $comment->id,
                'actor_id' => $comment->user_id,
            ]);

            $notification->users()->attach($parentPost->user_id, [
                'relation_type' => 'comment',
                'is_read' => false,
            ]);
        }
    }
}
