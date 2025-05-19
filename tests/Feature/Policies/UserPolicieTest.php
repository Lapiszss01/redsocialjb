<?php

use App\Models\User;
use App\Policies\UserPolicy;

beforeEach(function () {
    $this->policy = new UserPolicy();
});

it('denies viewing any users', function () {
    $user = User::factory()->make();
    expect($this->policy->viewAny($user))->toBeFalse();
});

it('denies viewing a specific user', function () {
    $user = User::factory()->make();
    $target = User::factory()->make();
    expect($this->policy->view($user, $target))->toBeFalse();
});

it('allows creating a user only if admin', function () {
    $admin = User::factory()->make(['role_id' => 1]);
    $normalUser = User::factory()->make(['role_id' => 2]);

    expect($this->policy->create($admin))->toBeTrue();
    expect($this->policy->create($normalUser))->toBeFalse();
});

it('allows updating a user only if admin', function () {
    $admin = User::factory()->make(['role_id' => 1]);
    $target = User::factory()->make();
    $normalUser = User::factory()->make(['role_id' => 2]);

    expect($this->policy->update($admin, $target))->toBeTrue();
    expect($this->policy->update($normalUser, $target))->toBeFalse();
});

it('allows deleting a user only if admin', function () {
    $admin = User::factory()->make(['role_id' => 1]);
    $target = User::factory()->make();
    $normalUser = User::factory()->make(['role_id' => 2]);

    expect($this->policy->delete($admin, $target))->toBeTrue();
    expect($this->policy->delete($normalUser, $target))->toBeFalse();
});

it('denies restoring a user', function () {
    $user = User::factory()->make();
    $target = User::factory()->make();
    expect($this->policy->restore($user, $target))->toBeFalse();
});

it('denies force deleting a user', function () {
    $user = User::factory()->make();
    $target = User::factory()->make();
    expect($this->policy->forceDelete($user, $target))->toBeFalse();
});

it('allows assigning role only if admin', function () {
    $admin = User::factory()->make(['role_id' => 1]);
    $normalUser = User::factory()->make(['role_id' => 3]);

    expect($this->policy->assignRole($admin))->toBeTrue();
    expect($this->policy->assignRole($normalUser))->toBeFalse();
});
