<?php

namespace App\Listeners;

use App\Events\PostCommented;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyPostOwnerOfComment
{
    public function handle(PostCommented $event): void
    {
        $post = $event->post;
        $actor = $event->actor;

        if ($actor->id === $post->user_id) return;

        $notification = Notification::create([
            'post_id' => $post->id,
            'actor_id' => $actor->id,
        ]);

        $notification->users()->attach($post->user_id, [
            'relation_type' => 'comment',
            'is_read' => false,
        ]);
    }
}
