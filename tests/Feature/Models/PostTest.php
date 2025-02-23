<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('only returns parent post', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    // Act & Assert
    expect(Post::where('parent_id',null)->get())
        ->toHaveCount(1);
});

it('has childs', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $childPost = Post::factory()->create(['user_id' => $user->id, 'parent_id' => $post->id]);
    // Act & Assert
    expect($post->children)
        ->toHaveCount(1);
});
