<?php

namespace App\Listeners;

use App\Events\PostLiked;
use App\Mail\PostLikedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendLikeNotification implements ShouldQueue
{
    public function handle(PostLiked $event)
    {
        $post = $event->post;
        $user = $event->user;

        Mail::to($post->user->email)->send(new PostLikedMail($post, $user));
    }
}
