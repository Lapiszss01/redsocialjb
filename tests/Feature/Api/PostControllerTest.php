<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('returns all users when index is accessed', function () {
    User::factory(3)->create();

    getJson(route('api.users.index'))
        ->assertStatus(200)
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'username',
                    'biography',
                ]
            ]
        ]);
});

it('returns users in the correct format', function () {
    $user = User::factory()->create();

    getJson(route('api.users.index'))
        ->assertStatus(200)
        ->assertJsonFragment(['id' => $user->id])
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'username',
                    'biography',
                ]
            ]
        ]);
});
