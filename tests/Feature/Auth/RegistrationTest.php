<?php


test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

use App\Mail\UserNewMail;
use App\Models\Role;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\get;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\post;


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


it('sends an email when a user is registered successfully', function () {
    Mail::fake();

    $response = post(route('register'), [
        'name' => 'Jane Doe',
        'username' => 'janedoe',
        'email' => 'jane@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => 'on',
    ]);

    $response->assertRedirect(route('home'));

    Mail::assertSent(UserNewMail::class, function ($mail) {
        return $mail->hasTo('jane@example.com') &&
            $mail->user->username === 'janedoe';
    });

    $this->assertDatabaseHas('users', [
        'email' => 'jane@example.com',
        'username' => 'janedoe',
    ]);
});




