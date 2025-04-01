<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('renders the admin users index page', function () {
    $admin = User::factory()->create();

    actingAs($admin);

    $response = get(route('admin.users'));

    $response->assertStatus(200)
        ->assertViewIs('admin.users.index')
        ->assertViewHas('users');
});

