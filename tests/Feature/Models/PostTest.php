<?php

use App\Models\Course;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;

it('only returns parent post', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    // Act & Assert
    expect(Post::where('parent_id',0)->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);
});

it('has childs', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $childPost = Post::factory()->create(['user_id' => $user->id, 'parent_id' => $post->id]);
    // Act & Assert
    expect($post->child)
        ->toHaveCount(1);
});
