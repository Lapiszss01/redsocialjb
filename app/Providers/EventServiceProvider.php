<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\PostLiked;
use App\Listeners\SendLikeNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PostLiked::class => [
            SendLikeNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
