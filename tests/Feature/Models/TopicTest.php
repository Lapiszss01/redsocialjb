<?php

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can have multiple posts', function () {
    // Arrange
    $user = User::factory()->create();
    $topic = Topic::factory()->create();
    $posts = Post::factory(3)->create(['user_id' => $user->id]);

    $topic->posts()->attach($posts);

    // Act & Assert
    expect($topic->posts)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Post::class);
});

it('can retrieve topics for a post', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $topics = Topic::factory(2)->create();

    $post->topics()->attach($topics);

    // Act & Assert
    expect($post->topics)
        ->toHaveCount(2)
        ->each->toBeInstanceOf(Topic::class);
});

it('can attach and detach posts', function () {
    // Arrange
    $user = User::factory()->create();
    $topic = Topic::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $topic->posts()->attach($post);
    expect($topic->posts)->toHaveCount(1);

    $topic->posts()->detach($post);
    expect($topic->fresh()->posts)->toHaveCount(0);
});

it('returns topics with at least one post', function () {
    // Arrange
    $user = User::factory()->create();
    $topicWithPost = Topic::factory()->create();
    $topicWithoutPost = Topic::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $topicWithPost->posts()->attach($post);

    // Act
    $topics = Topic::whereHas('posts')->get();

    // Assert
    expect($topics)
        ->toHaveCount(1)
        ->each->toBeInstanceOf(Topic::class);
});
