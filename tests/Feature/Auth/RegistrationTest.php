<?php



test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

use App\Models\Role;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

test('new users can register', function () {
    Role::factory()->create(['id' => 1]);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'username' => 'testuser',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);

    $response->assertRedirect(route('dashboard', absolute: false));
});



