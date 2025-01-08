<?php

use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\get;

it('shows post content', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    // Act & Assert
    get(route('post.show', $post))
        ->assertOk()
        ->assertSeeText([
            $post->title,
            $post->content,
            $post->created_at,
        ]);
});
