<?php

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;

beforeEach(function () {
    $this->policy = new PostPolicy();
});

it('denies viewing any post', function () {
    $user = User::factory()->make();
    expect($this->policy->viewAny($user))->toBeFalse();
});

it('denies viewing a specific post', function () {
    $user = User::factory()->make();
    $post = Post::factory()->make();
    expect($this->policy->view($user, $post))->toBeFalse();
});

it('allows creating a post', function () {
    $user = User::factory()->make();
    expect($this->policy->create($user))->toBeTrue();
});

it('denies updating a post', function () {
    $user = User::factory()->make();
    $post = Post::factory()->make();
    expect($this->policy->update($user, $post))->toBeFalse();
});

it('allows deleting if user is admin (role_id 1)', function () {
    $user = User::factory()->make(['role_id' => 1]);
    $post = Post::factory()->make();
    expect($this->policy->delete($user, $post))->toBeTrue();
});

it('allows deleting if user is moderator (role_id 2)', function () {
    $user = User::factory()->make(['role_id' => 2]);
    $post = Post::factory()->make();
    expect($this->policy->delete($user, $post))->toBeTrue();
});

it('allows deleting if user is the post owner', function () {
    $user = User::factory()->make(['role_id' => 3]);
    $post = Post::factory()->make(['user_id' => $user->id]);
    expect($this->policy->delete($user, $post))->toBeTrue();
});

it('denies deleting if user is not owner and not admin/moderator', function () {
    $user = User::factory()->make(['id' => 10, 'role_id' => 3]);
    $post = Post::factory()->make(['user_id' => 999]);
    expect($this->policy->delete($user, $post))->toBeFalse();
});

it('denies restoring a post', function () {
    $user = User::factory()->make();
    $post = Post::factory()->make();
    expect($this->policy->restore($user, $post))->toBeFalse();
});

it('denies force deleting a post', function () {
    $user = User::factory()->make();
    $post = Post::factory()->make();
    expect($this->policy->forceDelete($user, $post))->toBeFalse();
});
