<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Notification;

it('creates a notification for a post like', function () {
    $actor = User::factory()->create();
    $postOwner = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $postOwner->id]);

    event(new \App\Events\PostLiked($post, $actor));

    $notification = Notification::first();
    expect($notification)->not()->toBeNull();
    expect($notification->post_id)->toBe($post->id);

    $this->assertDatabaseHas('notification_user', [
        'user_id' => $postOwner->id,
        'notification_id' => $notification->id,
        'relation_type' => 'like',
        'is_read' => false
    ]);
});

it('does not create a notification if the actor is the post owner (like)', function () {
    $actor = User::factory()->create();
    $postOwner = $actor;
    $post = Post::factory()->create(['user_id' => $postOwner->id]);

    event(new \App\Events\PostLiked($post, $actor));


    $this->assertDatabaseCount('notifications', 0);
});

it('creates a notification for a post comment', function () {
    $actor = User::factory()->create();
    $postOwner = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $postOwner->id]);

    event(new \App\Events\PostCommented($post, $actor));

    $notification = Notification::first();
    expect($notification)->not()->toBeNull();
    expect($notification->post_id)->toBe($post->id);

    $this->assertDatabaseHas('notification_user', [
        'user_id' => $postOwner->id,
        'notification_id' => $notification->id,
        'relation_type' => 'comment',
        'is_read' => false
    ]);
});

it('does not create a notification if the actor is the post owner (comment)', function () {
    $actor = User::factory()->create();
    $postOwner = $actor;
    $post = Post::factory()->create(['user_id' => $postOwner->id]);

    event(new \App\Events\PostCommented($post, $actor));


    $this->assertDatabaseCount('notifications', 0);
});
