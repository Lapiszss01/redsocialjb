<?php


test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

use App\Models\Role;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\get;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\post;


uses(RefreshDatabase::class);

it('renders the registration page', function () {
    $response = get(route('register'));

    $response->assertStatus(200)
        ->assertViewIs('auth.register');
});

it('requires all fields for registration', function () {
    $response = post(route('register'), []);

    $response->assertSessionHasErrors(['name', 'username', 'email', 'password', 'terms']);
});

it('requires valid email and unique username', function () {
    User::factory()->create(['email' => 'john@example.com', 'username' => 'existinguser']);

    $response = post(route('register'), [
        'name' => 'John Doe',
        'username' => 'existinguser',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => 'on',
    ]);

    $response->assertSessionHasErrors(['email', 'username']);
});

it('can accept pdf terms optionally', function () {
    $response = post(route('register'), [
        'name' => 'Jane Doe',
        'username' => 'janedoe',
        'email' => 'jane@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => 'on',
        'pdfTerms' => 'on',
    ]);

    $response->assertRedirect(route('home'));

    $this->assertDatabaseHas('users', [
        'name' => 'Jane Doe',
        'username' => 'janedoe',
        'email' => 'jane@example.com',
    ]);

    $user = User::where('email', 'jane@example.com')->first();
    expect($user->terms_accepted_at)->not->toBeNull();
    expect($user->pdf_terms_accepted_at)->not->toBeNull();
});




