<?php

use App\Models\Topic;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

uses(RefreshDatabase::class);

beforeEach(function () {
    Pdf::shouldReceive('download')->andReturn(response('PDF generated', 200));
});

it('generates a PDF with user posts', function () {
    // Arrange
    $user = User::factory()->create();
    Post::factory(3)->create(['user_id' => $user->id]);

    // Mock PDF
    Pdf::shouldReceive('loadView')
        ->once()
        ->with('pdf.pdf-user-posts', \Mockery::on(function ($data) use ($user) {
            return $data['user']->id === $user->id && $data['posts']->count() === 3;
        }))
        ->andReturnSelf();

    // Act
    $response = $this->get(route('user.posts.pdf', ['id' => $user->id]));

    // Assert
    $response->assertStatus(200);
});

it('returns an error when the user has no posts', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $response = $this->get(route('user.posts.pdf', ['id' => $user->id]));

    // Assert
    $response->assertRedirect();
    $response->assertSessionHas('error', 'Este usuario no tiene posts.');
});

it('returns 404 if user does not exist', function () {
    // Act
    $response = $this->get(route('user.posts.pdf', ['id' => 99999]));

    // Assert
    $response->assertStatus(404);
});

it('generates a PDF with page analysis', function () {

    $users = User::factory(5)->create();
    $topics = Topic::factory(5)->create();

    Post::factory(10)->create([
        'user_id' => $users->random()->id,
    ]);

    Pdf::shouldReceive('loadView')
        ->once()
        ->with('pdf.pdf-page-analysis', \Mockery::on(function ($data) {
            return isset($data['topUsers']) && isset($data['topTopics']) &&
                isset($data['topLikedPosts']) && isset($data['mostCommentedPosts']);
        }))
        ->andReturnSelf();

    // Act
    $response = $this->get(route('pdf.analisis-general'));

    // Assert
    $response->assertStatus(200);
});
