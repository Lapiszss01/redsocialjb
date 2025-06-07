<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Notification;
use function Pest\Laravel\actingAs;


it('displays the notifications for a user', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $notifications = Notification::factory(3)->create([
        'post_id' => $post->id,
        'actor_id' => $user->id,
    ]);

    $data = $notifications->pluck('id')->mapWithKeys(function ($id) {
        return [$id => ['relation_type' => 'Like']];
    })->toArray();
    $user->notifications()->attach($data);
    actingAs($user);

    // Act
    $response = $this->get(route('notifications.index', $user));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('notifications.index');
    $response->assertViewHas('notifications', function ($viewNotifications) use ($notifications) {
        return $viewNotifications->count() === 3 &&
            $viewNotifications->pluck('id')->sort()->values()->all() ===
            $notifications->pluck('id')->sort()->values()->all();
    });
});
