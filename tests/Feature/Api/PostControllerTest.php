<?php

use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;

uses(RefreshDatabase::class);

it('gets all posts', function () {
    $user = User::factory()->create();
    Post::factory()->count(3)->create(['user_id' => $user->id]);

    $response = getJson(route('api.posts.index'));

    $response->assertOk()
        ->assertJsonCount(3, 'data');
});

it('gets posts by user with Admin token', function () {
    $admin = User::factory()->create();
    Sanctum::actingAs($admin, ['Admin']);

    $posts = Post::factory()->count(2)->create([
        'user_id' => $admin->id,
        'published_at' => now(),
    ]);

    $response = getJson(route('api.posts.getByUser', $admin->id));

    $response->assertOk()
        ->assertJsonCount(2, 'data');
});

it('forbids getting posts by user without Admin token', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user); // No token scope

    $response = getJson(route('api.posts.getByUser', $user->id));

    $response->assertForbidden();
});

it('returns 404 if user has no posts', function () {
    $admin = User::factory()->create();
    Sanctum::actingAs($admin, ['Admin']);

    $response = getJson(route('api.posts.getByUser', 999));

    $response->assertStatus(404);
});

it('stores a new post', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $data = [
        'user_id' => $user->id,
        'body' => 'This is a test post.',
        'image_url' => 'https://example.com/image.jpg',
        'published_at' => now()->toDateTimeString(),
    ];

    $response = postJson(route('posts.store'), $data);

    $response->assertCreated();
    expect($response['data']['body'])->toBe('This is a test post.');
});

it('shows a single post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $response = getJson(route('posts.show', $post));

    $response->assertOk()
        ->assertJsonPath('data.id', $post->id);
});

it('updates an existing post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['body' => 'Original', 'user_id' => $user->id]);

    $response = putJson(route('posts.update', $post), [
        'body' => 'Updated content',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.body', 'Updated content');
});

it('deletes a post', function () {
    $user = User::factory()->create();

    $post = Post::factory()->create(['user_id' => $user->id]);

    $response = deleteJson(route('posts.destroy', $post));

    $response->assertOk()
        ->assertJson(['message' => 'Post deleted successfully.']);
});

it('returns the correct data with UserResource', function () {

    $user = User::factory()->create([
        'username' => 'testuser',
        'biography' => 'This is a biography.'
    ]);

    $request = Request::create('/dummy-url', 'GET');

    $resource = new UserResource($user);
    $data = $resource->toArray($request);

    expect($data['id'])->toBe($user->id);
    expect($data['username'])->toBe($user->username);
    expect($data['biography'])->toBe($user->biography);
});
