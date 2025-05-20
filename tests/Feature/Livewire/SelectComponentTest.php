<?php

use App\Livewire\Components\SelectComponent;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
uses(RefreshDatabase::class);

it('mounts with userId, roleId, and all roles', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();

    $component = Livewire::test(SelectComponent::class, [
        'userId' => $user->id,
        'roleId' => $role->id,
    ]);

    $component->assertSet('userId', $user->id);
    $component->assertSet('roleId', $role->id);
    $component->assertViewHas('roles', fn ($roles) => $roles->contains($role));
});

it('updates user role when authorized', function () {
    $role1 = Role::factory()->create();
    $role2 = Role::factory()->create();
    $user = User::factory()->create(['role_id' => $role1->id]);
    $admin = User::factory()->create();

    actingAs($admin);
    Gate::define('assignRole', fn () => true);

    Livewire::test(SelectComponent::class, [
        'userId' => $user->id,
        'roleId' => $role1->id,
    ])
        ->set('roleId', $role2->id)
        ->assertSet('roleId', $role2->id);

    expect($user->fresh()->role_id)->toBe($role2->id);
});

it('does nothing if user is not found', function () {
    $role = Role::factory()->create();
    $admin = User::factory()->create();

    actingAs($admin);
    Gate::define('assignRole', fn () => true);

    Livewire::test(SelectComponent::class, [
        'userId' => 999,
        'roleId' => $role->id,
    ])
        ->call('updateRole', $role->id)
        ->assertSet('roleId', $role->id);
});

