<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;


uses(RefreshDatabase::class);

test('email verification screen can be rendered', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/verify-email');

    $response->assertStatus(200);
});



it('sends a verification email if not verified', function () {
    Notification::fake();

    $user = User::factory()->create(['email_verified_at' => null]);

    actingAs($user);

    $response = post(route('verification.send'));

    Notification::assertSentTo($user, \Illuminate\Auth\Notifications\VerifyEmail::class);
    $response->assertRedirect();
    $response->assertSessionHas('status', 'verification-link-sent');
});
