<?php

use App\Jobs\SendPostDeletedEmail;
use App\Mail\PostDeleted;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('sends a post deleted email when job is executed', function () {
    Mail::fake();

    $user = User::factory()->create();
    $postBody = 'Este es un post que ha sido eliminado.';

    $job = new SendPostDeletedEmail($user, $postBody);

    $job->handle();

    Mail::assertSent(PostDeleted::class, function ($mail) use ($user, $postBody) {
        return $mail->hasTo($user->email) && $mail->postBody === $postBody;
    });
});

