<?php

use App\Models\Like;
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

it('shows top posts created today with likes and comment count', function () {
    $user = User::factory()->create();
    $post1 = Post::factory()->create([
        'user_id' => $user->id,
        'body' => 'Primer post',
        'created_at' => now()->subHours(2),
    ]);

    $post2 = Post::factory()->create([
        'user_id' => $user->id,
        'body' => 'Segundo post',
        'created_at' => now()->subHours(1),
    ]);

    Like::factory()->count(3)->create(['post_id' => $post1->id, 'user_id' => $user->id]);
    Like::factory()->count(1)->create(['post_id' => $post2->id, 'user_id' => $user->id]);

    Post::factory()->create([
        'user_id' => $user->id,
        'parent_id' => $post1->id,
        'body' => 'Comentario al primer post',
        'created_at' => now(),
    ]);

    $post1->load('children');
    $post2->load('children');

    Post::macro('topLikedLastDay', function ($limit = 5) {
        return Post::withCount('likes')
            ->whereNull('parent_id')
            ->where('created_at', '>=', now()->subDay())
            ->orderByDesc('likes_count')
            ->limit($limit);
    });

    artisan('posts:send-daily-top')
        ->expectsOutput('📌 TOP 5 POSTS DEL DÍA:')
        ->expectsOutput("1. Primer post - 3 likes, 1 comentarios")
        ->expectsOutput("2. Segundo post - 1 likes, 0 comentarios")
        ->expectsOutput('Resumen de posts populares enviado.');
});

