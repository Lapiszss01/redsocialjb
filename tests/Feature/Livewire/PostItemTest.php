<?php


use App\Events\PostDeletedByAdmin;
use App\Events\PostLiked;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('renders post item component correctly', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test('posts.post-item', ['post' => $post])
        ->assertStatus(200);
});

it('toggles like status', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test('posts.post-item', ['post' => $post])
        ->call('toggleLike')
        ->assertSet('isLiked', true);

    $this->assertDatabaseHas('likes', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'liked' => true,
    ]);


});

it('redirects to login if not authenticated when liking', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    Livewire::test('posts.post-item', ['post' => $post])
        ->call('toggleLike')
        ->assertRedirect(route('login'));
});

it('redirects to post show page', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    Livewire::actingAs($user)
        ->test('posts.post-item', ['post' => $post])
        ->call('redirectToPost', $post->id)
        ->assertRedirect(route('post.show', ['post' => $post->id]));
});





