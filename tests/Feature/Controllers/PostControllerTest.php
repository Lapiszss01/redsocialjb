<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

it('returns recent posts in index', function () {
    // Arrange
    $user = User::factory()->create();
    $posts = Post::factory(3)->create(['user_id' => $user->id]);

    // Act
    $response = $this->get(route('home'));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('welcome');
    $response->assertViewHas('posts', function ($viewPosts) use ($posts) {
        return $viewPosts->count() === 3;
    });
});

it('displays a post and its child posts', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $childPosts = Post::factory(2)->create(['parent_id' => $post->id, 'user_id' => $user->id]);

    // Act
    $response = $this->get(route('post.show', $post));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('posts.show');
    $response->assertViewHas('post', $post);
    $response->assertViewHas('posts', function ($viewPosts) use ($childPosts) {
        return $viewPosts->count() === 2;
    });
});
