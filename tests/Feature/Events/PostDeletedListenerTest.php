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

it('sends an email when a post with user is deleted', function () {
    Mail::fake();
    Log::shouldReceive('info')->once();

    $user = User::factory()->create();
    $post = Post::factory()->for($user)->create();

    $event = new PostDeletedByAdmin($post);

    (new SendPostDeletedNotification)->handle($event);

    Mail::assertSent(PostDeletedMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
});

it('does not send an email when post has no user', function () {
    Mail::fake();
    Log::shouldReceive('info')->never();

    $post = Post::factory()->make(['user_id' => null]);
    $post->setRelation('user', null);

    $event = new PostDeletedByAdmin($post);

    (new SendPostDeletedNotification)->handle($event);

    Mail::assertNothingSent();
});
