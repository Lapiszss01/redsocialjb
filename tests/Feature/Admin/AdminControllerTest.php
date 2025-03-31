<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('renders the admin users index page', function () {
    $admin = User::factory()->create(); // Crea un usuario

    actingAs($admin); // Autentica al usuario

    $response = get(route('admin.users'));

    $response->assertStatus(200)
        ->assertViewIs('admin.users.index')
        ->assertViewHas('users');
});
