<?php


use App\Events\PostLiked;
use App\Listeners\SendLikeNotification;
use App\Mail\PostLikedMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('dispatches the PostLiked event when a post is liked', function () {
    Event::fake();

    $user = User::factory()->create();
    $postOwner = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $postOwner->id]);

    actingAs($user);

    event(new PostLiked($post, $user));

    Event::assertDispatched(PostLiked::class, function ($event) use ($post, $user) {
        return $event->post->id === $post->id && $event->user->id === $user->id;
    });
});

it('sends an email when a post is liked', function () {
    Mail::fake();

    $user = User::factory()->create();
    $postOwner = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $postOwner->id]);

    event(new PostLiked($post, $user));

    Mail::assertSent(PostLikedMail::class, function ($mail) use ($postOwner, $user, $post) {
        return $mail->hasTo($postOwner->email) &&
            $mail->user->id === $user->id &&
            $mail->post->id === $post->id;
    });
});



