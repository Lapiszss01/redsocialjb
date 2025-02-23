<?php

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use function Pest\Laravel\artisan;

uses(RefreshDatabase::class);

it('does not show any posts if no posts have been created today', function () {
    $user = User::factory()->create();
    $postOwner = User::factory()->create();

    Post::factory()->create(['user_id' => $postOwner->id, 'created_at' => Carbon::now()->subDays(2)]);

    artisan('posts:send-daily-top')
        ->expectsOutput('No hay posts populares para mostrar hoy.');
});

it('shows a warning if there are no posts created today', function () {
    artisan('posts:send-daily-top')
        ->expectsOutput('No hay posts populares para mostrar hoy.');
});

