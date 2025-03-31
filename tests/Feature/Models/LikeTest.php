<?php

use App\Livewire\LikeButton;
use App\Livewire\Posts\PostItem;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

it('allows an authenticated user to like a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    actingAs($user);

    livewire(PostItem::class, ['post' => $post])
        ->call('toggleLike');

    expect($post->likes()->where('user_id', $user->id)->where('liked', true)->exists())->toBeTrue();
});

it('allows an authenticated user to unlike a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    actingAs($user);

    livewire(PostItem::class, ['post' => $post])
        ->call('toggleLike');

    livewire(PostItem::class, ['post' => $post])
        ->call('toggleLike');

    expect($post->likes()->where('user_id', $user->id)->where('liked', true)->exists())->toBeTrue();
});

it('redirects an unauthenticated user to login when trying to like a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    livewire(PostItem::class, ['post' => $post])
        ->call('toggleLike')
        ->assertRedirect(route('login'));
});

it('correctly updates the like count', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    actingAs($user);

    livewire(PostItem::class, ['post' => $post])
        ->call('toggleLike')
        ->assertSee($post->likes->count());

    expect($post->likes->count())->toBe(1);
});

