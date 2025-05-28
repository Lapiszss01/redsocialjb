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

    $response = getJson(route('api.topics.index'));

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
    $user = User::factory()->create();
    $topic = Topic::factory()->create();
    actingAs($user);
    $response = getJson(route('topics.show', $topic->id));

    $response->assertStatus(200)
        ->assertJson(['data' => ['id' => $topic->id, 'name' => $topic->name]]);
});

it('updates a topic', function () {
    $user = User::factory()->create();
    $topic = Topic::factory()->create();

    $data = ['name' => 'Updated Topic Name'];
    actingAs($user);
    $response = putJson(route('topics.update', $topic->id), $data);

    $response->assertStatus(200)
        ->assertJson(['message' => 'Topic updated successfully'])
        ->assertJson(['data' => ['name' => 'Updated Topic Name']]);
});

it('deletes a topic', function () {
    $user = User::factory()->create();
    $topic = Topic::factory()->create();

    actingAs($user);
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

it('retrieves the 10 most used topics', function () {
    $topics = Topic::factory()->count(3)->create();
    $user = User::factory()->create();
    actingAs($user);

    foreach ($topics as $topic) {
        $topic->posts()->createMany([
            ['title' => 'Post 1', 'body' => 'Body', 'user_id' => $user->id],
            ['title' => 'Post 2', 'body' => 'Body', 'user_id' => $user->id],
        ]);
    }

    $response = getJson(route('topics.most-used'));

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => [['id', 'name']]]);
});

it('returns 404 if no topics are found in mostUsedTopic', function () {
    $user = User::factory()->create();
    actingAs($user);

    $response = getJson(route('topics.most-used'));

    $response->assertStatus(404)
        ->assertJson(['message' => 'No topics found']);
});
