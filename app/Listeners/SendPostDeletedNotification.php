<?php

namespace App\Listeners;

use App\Events\PostDeletedByAdmin;
use App\Mail\PostDeletedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPostDeletedNotification
{
    public function handle(PostDeletedByAdmin $event)
    {
        $post = $event->post;
        $user = $post->user;

        if ($user) {
            Log::info("Enviando correo a: {$user->email}");
            Mail::to($user->email)->send(new PostDeletedMail($post));
        }
    }
}
