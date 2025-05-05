<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('only returns parent posts', function () {
    // Arrange
    $user = User::factory()->create();
    $parentPost = Post::factory()->create(['user_id' => $user->id]);
    $childPost = Post::factory()->create(['user_id' => $user->id, 'parent_id' => $parentPost->id]);

    // Act & Assert
    expect(Post::whereNull('parent_id')->get())
        ->toHaveCount(1)
        ->each->toBeInstanceOf(Post::class);
});

it('has children posts', function () {
    // Arrange
    $user = User::factory()->create();
    $parentPost = Post::factory()->create(['user_id' => $user->id]);
    $childPost = Post::factory()->create(['user_id' => $user->id, 'parent_id' => $parentPost->id]);

    // Act & Assert
    expect($parentPost->children)
        ->toHaveCount(1)
        ->each->toBeInstanceOf(Post::class);
});

it('returns recent parent posts ordered by creation', function () {
    // Arrange
    $user = User::factory()->create();
    $olderPost = Post::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDays(2)]);
    $newerPost = Post::factory()->create(['user_id' => $user->id, 'created_at' => now()]);
    $childPost = Post::factory()->create(['user_id' => $user->id, 'parent_id' => $olderPost->id]);

    // Act
    $recentPosts = Post::recent()->get();

    // Assert
    expect($recentPosts)
        ->toHaveCount(2)
        ->sequence(fn ($post) => $post->id === $newerPost->id);
});

it('returns posts by a specific user', function () {
    // Arrange
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    Post::factory(2)->create(['user_id' => $user1->id]);
    Post::factory(3)->create(['user_id' => $user2->id]);

    // Act
    $user1Posts = Post::publishedMainPostsByUser($user1->id)->get();

    // Assert
    expect($user1Posts)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Post::class);
});

it('a post belongs to a user', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    // Assert
    expect($post->user)->toBeInstanceOf(User::class)
        ->and($post->user->id)->toBe($user->id);
});

