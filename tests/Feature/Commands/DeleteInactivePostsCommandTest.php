<?php

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use function Pest\Laravel\artisan;


it('does not delete posts if there are no inactive posts', function () {
    $postOwner = User::factory()->create();

    Post::factory()->create([
        'user_id' => $postOwner->id,
        'created_at' => Carbon::now()->subDays(10),
    ]);

    artisan('posts:delete-inactive', ['days' => 30])
        ->expectsOutput('Se eliminaron 0 posts inactivos.');

    expect(Post::count())->toBe(1);
});

it('deletes posts based on the default days argument (30)', function () {
    $postOwner = User::factory()->create();

    $postWithoutLike = Post::factory()->create([
        'user_id' => $postOwner->id,
        'created_at' => Carbon::now()->subDays(40),
    ]);

    artisan('posts:delete-inactive')
        ->expectsOutput('Se eliminaron 1 posts inactivos.');

    expect(Post::find($postWithoutLike->id))->toBeNull();
});


