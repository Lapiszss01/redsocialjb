<?php

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('retrieves all topics', function () {
    Topic::factory()->count(3)->create();

    $response = getJson(route('topics.index'));

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => []])
        ->assertJsonCount(3, 'data');
});

it('creates a new topic', function () {
    $user = User::factory()->create();
    actingAs($user);

    $data = ['name' => 'New Topic'];

    $response = postJson(route('topics.store'), $data);

    $response->assertStatus(201)
        ->assertJson(['message' => 'Topic created successfully'])
        ->assertJsonStructure(['data' => ['id', 'name']]);
});

it('shows a specific topic', function () {
    $topic = Topic::factory()->create();

    $response = getJson(route('topics.show', $topic->id));

    $response->assertStatus(200)
        ->assertJson(['data' => ['id' => $topic->id, 'name' => $topic->name]]);
});

it('updates a topic', function () {
    $topic = Topic::factory()->create();

    $data = ['name' => 'Updated Topic Name'];

    $response = putJson(route('topics.update', $topic->id), $data);

    $response->assertStatus(200)
        ->assertJson(['message' => 'Topic updated successfully'])
        ->assertJson(['data' => ['name' => 'Updated Topic Name']]);
});

it('deletes a topic', function () {
    $topic = Topic::factory()->create();

    $response = deleteJson(route('topics.destroy', $topic->id));

    $response->assertStatus(200)
        ->assertJson(['message' => 'Topic deleted successfully']);
});

it('retrieves posts for a topic', function () {
    $topic = Topic::factory()->create();
    $user = User::factory()->create();
    $post = $topic->posts()->create(['title' => 'Post related to topic', 'body' => 'Some content','user_id' => $user->id]);

    $response = getJson(route('api.posts.index', $topic->id));

    $response->assertStatus(200);
});
