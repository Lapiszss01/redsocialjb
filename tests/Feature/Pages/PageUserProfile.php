<?php

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;


it('loads the user profile page with posts', function () {
    // Arrange
    $user = User::factory()->create(['username' => 'john_doe']);
    $post1 = Post::factory()->create(['user_id' => $user->id, 'body' => 'First Post']);
    $post2 = Post::factory()->create(['user_id' => $user->id, 'body' => 'Second Post']);

    // Act
    $response = $this->get(route('profile', ['username' => 'john_doe']));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('userprofile.user-profile');
    $response->assertViewHas('user', $user);
    $response->assertViewHas('posts', function ($posts) use ($post1, $post2) {
        return $posts->contains($post1) && $posts->contains($post2);
    });
});

it('returns a 404 if user is not found', function () {
    // Act
    $response = $this->get(route('profile', ['username' => 'non_existent_user']));

    // Assert
    $response->assertStatus(404);
});

it('correctly displays the user profile with the correct username', function () {
    // Arrange
    $user = User::factory()->create(['username' => 'alice_smith']);
    $post = Post::factory()->create(['user_id' => $user->id, 'body' => 'Alice\'s Post']);

    // Act
    $response = $this->get(route('profile', ['username' => 'alice_smith']));

    // Assert
    $response->assertStatus(200);
    $response->assertSee($user->username);
    $response->assertSee($post->title);
});
