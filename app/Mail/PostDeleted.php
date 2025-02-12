<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $postBody;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $postBody)
    {
        $this->user = $user;
        $this->postBody = $postBody;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Tu post ha sido eliminado')
            ->view('emails.post-deleted')
            ->with([
                'name' => $this->user->name,
                'postBody' => $this->postBody,
            ]);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.post-deleted',
        );
    }

}
