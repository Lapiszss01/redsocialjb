<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PostDeletedByAdmin
{
    use Dispatchable, SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
        Log::info("SOCORRO2");

    }
}
