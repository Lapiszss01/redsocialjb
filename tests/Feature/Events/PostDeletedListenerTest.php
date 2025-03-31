<?php

use App\Events\PostDeletedByAdmin;
use App\Listeners\SendPostDeletedNotification;
use App\Mail\PostDeletedMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use function Pest\Laravel\actingAs;


uses(RefreshDatabase::class);

it('dispatches the PostDeletedByAdmin event when an admin deletes a post', function () {
    Event::fake();

    $admin = User::factory()->create(['role_id' => 1]);
    $postOwner = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $postOwner->id]);

    actingAs($admin);

    event(new PostDeletedByAdmin($post));

    Event::assertDispatched(PostDeletedByAdmin::class, function ($event) use ($post) {
        return $event->post->id === $post->id;
    });
});

it('sends an email when a post is deleted by an admin', function () {
    Mail::fake();
    Log::spy(); // Captura todas las llamadas a Log::info()

    $postOwner = User::factory()->create(['email' => 'test@example.com']);
    $post = Post::factory()->create(['user_id' => $postOwner->id]);

    event(new PostDeletedByAdmin($post));

    Mail::assertSent(PostDeletedMail::class, function ($mail) use ($postOwner, $post) {
        return $mail->hasTo($postOwner->email) &&
            $mail->post->id === $post->id;
    });
    Log::shouldHaveReceived('info')->with("Enviando correo a: test@example.com");
});
