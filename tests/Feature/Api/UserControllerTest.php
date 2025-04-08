<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\deleteJson;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
});

it('gets all users', function () {
    User::factory()->count(3)->create();

    $response = getJson('/api/users');

    $response->assertOk()
        ->assertJsonStructure(['data']);
});

it('creates a new user', function () {
    $data = [
        'username' => 'testuser',
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'biography' => 'A short bio.',
        'role_id' => 1,
    ];

    $response = postJson('/api/users', $data);

    $response->assertCreated()
        ->assertJsonStructure(['data' => ['id', 'name', 'email', 'username']]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});

it('shows a user by ID', function () {
    $user = User::factory()->create();

    $response = getJson("/api/users/{$user->id}");

    $response->assertOk()
        ->assertJson(['data' => ['id' => $user->id]]);
});

it('returns 404 for non-existent user in show', function () {
    $response = getJson('/api/users/999999');
    $response->assertNotFound();
});

it('updates a user', function () {
    $user = User::factory()->create();

    $response = putJson("/api/users/{$user->id}", [
        'name' => 'Updated Name',
        'password' => 'newpassword',
    ]);

    $response->assertOk()
        ->assertJson(['data' => ['name' => 'Updated Name']]);

    $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
});

it('returns 404 on update for missing user', function () {
    $response = putJson('/api/users/999999', ['name' => 'New Name']);
    $response->assertNotFound();
});

it('deletes a user', function () {
    $user = User::factory()->create();

    $response = deleteJson("/api/users/{$user->id}");

    $response->assertOk()
        ->assertJson(['message' => 'User deleted']);

    $this->assertModelMissing($user);
});

it('returns 404 on delete for missing user', function () {
    $response = deleteJson('/api/users/999999');
    $response->assertNotFound();
});

