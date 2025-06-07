<?php

use App\Jobs\DeleteInactiveUsers;
use App\Jobs\PruneOldNotifications;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

it('deletes notifications older than 60 days', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    Notification::factory()->create(['actor_id'=>$user->id ,'post_id'=>$post->id ,'created_at' => now()->subDays(61)]);
    Notification::factory()->create(['actor_id'=>$user->id ,'post_id'=>$post->id ,'created_at' => now()->subDays(10)]);

    $this->assertDatabaseCount('notifications', 2);

    (new PruneOldNotifications())->handle();

    $this->assertDatabaseCount('notifications', 1);
});

it('does not delete notifications newer than 60 days', function () {

    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    Notification::factory()->create(['actor_id'=>$user->id ,'post_id'=>$post->id ,'created_at' => now()->subDays(30)]);
    Notification::factory()->create(['actor_id'=>$user->id ,'post_id'=>$post->id ,'created_at' => now()]);

    $this->assertDatabaseCount('notifications', 2);

    (new PruneOldNotifications())->handle();

    $this->assertDatabaseCount('notifications', 2);
});
