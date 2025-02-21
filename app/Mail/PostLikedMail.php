<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostLikedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject("¡Tu post ha recibido un like!")
            ->view('emails.post-liked');
    }
}
