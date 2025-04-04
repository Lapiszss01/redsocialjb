<?php

use App\Jobs\DeleteInactiveUsers;
use App\Livewire\UserRoleManager;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

use function Pest\Laravel\artisan;

test('it renders user role manager', function () {
    Livewire::test(UserRoleManager::class)
        ->assertStatus(200);
});

test('it updates a user role', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create();

    Livewire::test(UserRoleManager::class)
        ->call('updateRole', $user->id, $role->id);

    expect($user->fresh()->role_id)->toBe($role->id);
});

test('it creates a new user', function () {
    Livewire::test(UserRoleManager::class)
        ->set('name', 'John Doe')
        ->set('username', 'johndoe')
        ->set('email', 'john@example.com')
        ->set('password', 'secret')
        ->call('createUser');

    $user = User::where('email', 'john@example.com')->first();
    expect($user)->not->toBeNull();
    expect(Hash::check('secret', $user->password))->toBeTrue();
});

test('it edits and updates a user', function () {
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);

    Livewire::test(UserRoleManager::class)
        ->call('editUser', $user->id)
        ->set('name', 'New Name')
        ->set('email', 'new@example.com')
        ->call('updateUser');

    expect($user->fresh()->name)->toBe('New Name');
    expect($user->fresh()->email)->toBe('new@example.com');
});

test('it deletes a user and their posts', function () {
    $user = User::factory()->create();
    Post::factory()->count(2)->create(['user_id' => $user->id]);

    Livewire::test(UserRoleManager::class)
        ->call('confirmDelete', $user->id);

    expect(User::find($user->id))->toBeNull();
    expect(Post::where('user_id', $user->id)->count())->toBe(0);
});

test('it dispatches DeleteInactiveUsers job', function () {
    Bus::fake();

    Livewire::test(UserRoleManager::class)
        ->call('deleteInactiveUsers')
        ->assertSet('message', 'Job ejecutado correctamente.');

    Bus::assertDispatched(DeleteInactiveUsers::class);
});

test('it calls artisan command to delete inactive posts', function () {
    Artisan::spy();

    Livewire::test(UserRoleManager::class)
        ->call('deleteInactivePosts')
        ->assertSet('message', 'Borrados posts inactivos.');

    Artisan::shouldHaveReceived('call')->with('posts:delete-inactive', ['days' => 30]);
});
