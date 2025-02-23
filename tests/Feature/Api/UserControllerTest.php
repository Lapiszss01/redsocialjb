<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('returns all posts when index is accessed', function () {

    $user = User::factory()->create();
    Post::factory(3)->create(['user_id' => $user->id]);

    getJson(route('api.posts.index'))
        ->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

it('returns a specific user posts with getByUser', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    $userPosts = Post::factory(2)->create(['user_id' => $user->id]);
    $otherUserPosts = Post::factory(2)->create(['user_id' => $otherUser->id]);

    getJson(route('api.posts.getByUser', ['userId' => $user->id]))
        ->assertStatus(200)
        ->assertJsonCount(2, 'data')  // Verifica que la respuesta tiene 2 posts
        ->assertJsonFragment(['id' => $userPosts[0]->id])
        ->assertJsonFragment(['id' => $userPosts[1]->id]);

    // Obtener los posts de un usuario sin posts
    getJson(route('api.posts.getByUser', ['userId' => 999]))  // ID que no existe
    ->assertStatus(404)
        ->assertJson(['message' => 'No posts found for this user']);
});

it('returns 404 when there are no posts for a user in getByUser', function () {
    $user = User::factory()->create();

    // Petición para obtener posts de un usuario que no tiene posts
    getJson(route('api.posts.getByUser', ['userId' => $user->id]))
        ->assertStatus(404)
        ->assertJson(['message' => 'No posts found for this user']);
});


