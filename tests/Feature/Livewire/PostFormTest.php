<?php

use App\Livewire\Posts\PostForm;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('can render post form component', function () {
    Livewire::test(PostForm::class)
        ->assertStatus(200);
});

test('can create a post with image and hashtags', function () {
    Storage::fake('public');
    $user = User::factory()->create();

    $image = UploadedFile::fake()->image('test.jpg');

    Livewire::actingAs($user)
        ->test(PostForm::class)
        ->set('body', 'Hello #Laravel #Livewire')
        ->set('image', $image)
        ->call('save')
        ->assertDispatched('postUpdated');

    $this->assertDatabaseHas('posts', [
        'body' => 'Hello #Laravel #Livewire',
        'user_id' => $user->id,
    ]);

    $post = Post::first();

    expect($post->topics)->toHaveCount(2);
    expect(Storage::disk('public')->exists($post->image_url))->toBeTrue();
});

test('can edit a post and update its body', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id, 'body' => 'Old body']);

    Livewire::actingAs($user)
        ->test(PostForm::class)
        ->call('edit', $post)
        ->set('body', 'Updated body')
        ->call('save')
        ->assertDispatched('postUpdated');

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'body' => 'Updated body',
    ]);
});

test('published_at is set correctly when not provided', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(PostForm::class)
        ->set('body', 'Testing published_at')
        ->call('save');

    $this->assertNotNull(Post::first()->published_at);
});

test('published_at can be set via event', function () {
    $user = User::factory()->create();
    $date = now()->addDays(2)->format('Y-m-d H:i:s');

    Livewire::actingAs($user)
        ->test(PostForm::class)
        ->dispatch('updatePublishedAt', $date)
        ->set('body', 'Scheduled post')
        ->call('save');

    $this->assertEquals($date, Post::first()->published_at);
});


