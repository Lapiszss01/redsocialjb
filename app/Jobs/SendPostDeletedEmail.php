<?php

namespace App\Jobs;

use App\Mail\PostDeleted;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendPostDeletedEmail implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $postBody;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, $postBody)
    {
        $this->user = $user;
        $this->postBody = $postBody;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new PostDeleted($this->user, $this->postBody));
    }
}
