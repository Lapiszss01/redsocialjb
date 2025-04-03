<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\actingAs;

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
    $childPosts = Post::factory(2)->create(['parent_id' => $post->id,'user_id' => $user->id]);

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

it('displays a user profile with their posts', function () {
    // Arrange
    $user = User::factory()->create(['username' => 'testuser']);
    $posts = Post::factory(2)->create(['user_id' => $user->id]);

    // Act
    $response = $this->get(route('profile', $user->username));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('userprofile.user-profile');
    $response->assertViewHas('user', $user);
    $response->assertViewHas('posts', function ($viewPosts) use ($posts) {
        return $viewPosts->count() === 2;
    });
});

it('renders the user profile edit form', function () {
    // Arrange
    $user = User::factory()->create();
    actingAs($user);
    // Act
    $response = $this->get(route('userprofile.edit', $user));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('userprofile.edit');
    $response->assertViewHas('user', $user);
});

it('updates user profile data', function () {
    // Arrange
    $user = User::factory()->create(['username' => 'olduser']);
    $this->actingAs($user); // Autenticar al usuario
    $newData = ['username' => 'newuser', 'email' => 'newemail@example.com','name'=>$user->name, 'biography' => $user->biography];

    // Act
    $response = $this->patch(route('userprofile.update', $user), $newData);

    // Assert
    $response->assertRedirect(route('profile', 'newuser'));
    $response->assertSessionHas('status', 'Post updated successfully');
    $this->assertDatabaseHas('users', ['id' => $user->id, 'username' => 'newuser', 'email' => 'newemail@example.com']);
});
