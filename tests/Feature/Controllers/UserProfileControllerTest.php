<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Maatwebsite\Excel\Validators\Failure;
use function Pest\Laravel\actingAs;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PostsImport;

uses(RefreshDatabase::class);

it('returns recent posts in index', function () {
    // Arrange
    $user = User::factory()->create();
    $posts = Post::factory(3)->create(['user_id' => $user->id]);

    // Act
    $response = $this->get(route('home'));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('welcome');
    $response->assertViewHas('posts', function ($viewPosts) use ($posts) {
        return $viewPosts->count() === 3;
    });
});

it('displays a post and its child posts', function () {
    // Arrange
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $childPosts = Post::factory(2)->create(['parent_id' => $post->id,'user_id' => $user->id]);

    // Act
    $response = $this->get(route('post.show', $post));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('posts.show');
    $response->assertViewHas('post', $post);
    $response->assertViewHas('posts', function ($viewPosts) use ($childPosts) {
        return $viewPosts->count() === 2;
    });
});

it('displays a user profile with their posts', function () {
    // Arrange
    $user = User::factory()->create(['username' => 'testuser']);
    $posts = Post::factory(2)->create(['user_id' => $user->id]);

    // Act
    $response = $this->get(route('profile', $user->username));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('userprofile.user-profile');
    $response->assertViewHas('user', $user);
    $response->assertViewHas('posts', function ($viewPosts) use ($posts) {
        return $viewPosts->count() === 2;
    });
});

it('renders the user profile edit form', function () {
    // Arrange
    $user = User::factory()->create();
    actingAs($user);
    // Act
    $response = $this->get(route('userprofile.edit', $user));

    // Assert
    $response->assertStatus(200);
    $response->assertViewIs('userprofile.edit');
    $response->assertViewHas('user', $user);
});

it('updates user profile data', function () {
    // Arrange
    $user = User::factory()->create(['username' => 'olduser']);
    $this->actingAs($user); // Autenticar al usuario
    $newData = ['username' => 'newuser', 'email' => 'newemail@example.com','name'=>$user->name, 'biography' => $user->biography];

    // Act
    $response = $this->patch(route('userprofile.update', $user), $newData);

    // Assert
    $response->assertRedirect(route('profile', 'newuser'));
    $response->assertSessionHas('status', 'Post updated successfully');
    $this->assertDatabaseHas('users', ['id' => $user->id, 'username' => 'newuser', 'email' => 'newemail@example.com']);
});

it('uploads a profile photo and replaces the old one if exists', function () {
    // Arrange
    Storage::fake('public');

    $user = User::factory()->create([
        'profile_photo' => 'profile-photos/oldphoto.jpg'
    ]);

    Storage::disk('public')->put('profile-photos/oldphoto.jpg', 'fake content');

    $this->actingAs($user);

    $file = \Illuminate\Http\UploadedFile::fake()->image('newphoto.jpg');

    // Act
    $response = $this->post(route('profile.upload-photo'), [
        'file' => $file,
    ]);

    // Assert
    $response->assertStatus(200);
    $response->assertJsonStructure(['path']);

    Storage::disk('public')->assertMissing('profile-photos/oldphoto.jpg');
    Storage::disk('public')->assertExists("profile-photos/{$file->hashName()}");

    $user->refresh();
    expect($user->profile_photo)->toBe("profile-photos/{$file->hashName()}");
});

it('fails to upload if file is not an image', function () {
    // Arrange
    $user = User::factory()->create();
    $this->actingAs($user);

    $invalidFile = \Illuminate\Http\UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

    // Act
    $response = $this->post(route('profile.upload-photo'), [
        'file' => $invalidFile,
    ]);

    // Assert
    $response->assertSessionHasErrors('file');
});

it('imports posts successfully with no validation errors', function () {
    Storage::fake('local');
    Excel::fake();

    $user = User::factory()->create();
    actingAs($user);

    $file = UploadedFile::fake()->create('posts.xlsx');

    $response = $this->post(route('posts.import'), [
        'file' => $file,
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', __("Posts imported successfully!"));
    Excel::assertImported('posts.xlsx', function ($import) {
        return $import instanceof PostsImport;
    });
});

it('handles unexpected exceptions during import', function () {
    Excel::shouldReceive('import')->andThrow(new Exception('Explosión inesperada'));

    $user = User::factory()->create();
    actingAs($user);

    $file = UploadedFile::fake()->create('posts.xlsx');

    $response = $this->post(route('posts.import'), [
        'file' => $file,
    ]);

    $response->assertSessionHasErrors(['file' => __("Something went wrong while processing the file.")]);
    $response->assertSessionHas('error', __("Unexpected error."));
});
