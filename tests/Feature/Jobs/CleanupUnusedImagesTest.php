<?php

use App\Jobs\CleanupUnusedImagesJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

it('deletes unused images from storage', function () {
    // Arrange
    Storage::fake('public');

    $usedImage = 'uploads/used_image.jpg';
    $unusedImage = 'uploads/unused_image.jpg';

    Storage::disk('public')->put($usedImage, 'dummy content');
    Storage::disk('public')->put($unusedImage, 'dummy content');

    $user = User::factory()->create();
    Post::factory()->create(['image_url' => Storage::url($usedImage), 'user_id' => $user->id]);

    // Act
    (new CleanupUnusedImagesJob())->handle();

    // Assert
    Storage::disk('public')->assertExists($usedImage);
    Storage::disk('public')->assertMissing($unusedImage);
});

it('does not delete images in use', function () {
    // Arrange
    Storage::fake('public');

    $usedImage = 'uploads/used_image.jpg';
    Storage::disk('public')->put($usedImage, 'dummy content');

    $user = User::factory()->create();
    Post::factory()->create(['image_url' => Storage::url($usedImage), 'user_id' => $user->id]);

    // Act
    (new CleanupUnusedImagesJob())->handle();

    // Assert
    Storage::disk('public')->assertExists($usedImage);
});

it('dispatches the job successfully', function () {
    // Arrange
    Queue::fake();

    // Act
    CleanupUnusedImagesJob::dispatch();

    // Assert
    Queue::assertPushed(CleanupUnusedImagesJob::class);
});
