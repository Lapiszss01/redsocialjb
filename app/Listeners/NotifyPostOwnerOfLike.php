<?php

namespace App\Listeners;

use App\Events\PostLiked;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyPostOwnerOfLike
{
    public function handle(PostLiked $event): void
    {
        $post = $event->post;
        $actor = $event->user;

        if ($actor->id === $post->user_id) return;

        $notification = Notification::create([
            'post_id' => $post->id,
            'actor_id' => $actor->id,
        ]);

        $notification->users()->attach($post->user_id, [
            'relation_type' => 'like',
            'is_read' => false,
        ]);
    }
}
