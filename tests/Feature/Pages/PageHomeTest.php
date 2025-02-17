<?php

use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\get;

it('show posts overview', function () {

    $user = User::factory()->create();

    $post1 = Post::factory()->create(['user_id' => $user->id]);
    $post2 = Post::factory()->create(['user_id' => $user->id]);
    $post3 = Post::factory()->create(['user_id' => $user->id]);

    get(route('home'))
    ->assertSeeText([
       $post1->title,
       $post2->title,
       $post3->title,
    ]);

});

it('includes login if not logged in', function () {
    // Act & Assert
    get(route('home'))
        ->assertOk()
        ->assertSeeText(__("Log in"))
        ->assertSee(route('login'));

});

it('includes logout if logged in', function () {
    // Act & Assert
    loginAsUser();
    get(route('home'))
        ->assertOk()
        ->assertSeeText(__("Logout"))
        ->assertSee(route('logout'));

});

