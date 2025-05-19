<?php

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\artisan;


uses(RefreshDatabase::class);

it('shows the top topics used in posts created today', function () {
    $user = User::factory()->create();
    $topic1 = Topic::factory()->create(['name' => 'PHP']);
    $topic2 = Topic::factory()->create(['name' => 'Laravel']);

    $post1 = Post::factory()->create(['created_at' => now(),'user_id' => $user->id]);
    $post2 = Post::factory()->create(['created_at' => now(),'user_id' => $user->id]);

    $post1->topics()->attach([$topic1->id, $topic2->id]);
    $post2->topics()->attach([$topic2->id]);

    artisan('topics:top-today', ['count' => 2])
        ->expectsOutput('📚 TOP 2 TOPICS DEL DÍA:')
        ->expectsOutput('1. Laravel - 2 posts')
        ->expectsOutput('2. PHP - 1 posts');

});

it('warns when there are no posts created today', function () {
    $user = User::factory()->create();
    $topic = Topic::factory()->create(['name' => 'Vue.js']);
    $post = Post::factory()->create(['user_id'=>$user->id,'created_at' => now()->subDay()]);
    $post->topics()->attach($topic->id);

    artisan('topics:top-today')
        ->expectsOutput('No hay topics utilizados hoy.');

});
