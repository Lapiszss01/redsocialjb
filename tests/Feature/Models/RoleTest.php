<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a role', function () {
    $role = Role::factory()->create(['name' => 'Admin']);

    expect($role->name)->toBe('Admin');
    expect($role->display_name)->not()->toBeNull();
    expect($role->description)->not()->toBeNull();
});

it('has many users', function () {
    $role = Role::factory()->create(['name' => 'Admin']);
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $user1->role()->associate($role);
    $user1->save();

    $user2->role()->associate($role);
    $user2->save();

    expect($role->users)->toHaveCount(2);
});

it('can return users associated with the role', function () {
    $role = Role::factory()->create(['name' => 'Editor']);
    $user = User::factory()->create();

    $user->role()->associate($role);
    $user->save();

    expect($role->users->first()->id)->toBe($user->id);
});

