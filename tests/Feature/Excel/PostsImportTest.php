<?php

use App\Imports\PostsImport;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('imports a valid post row and saves it in the database', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    Auth::login($user);

    $filename = 'valid_posts.xlsx';
    $rows = [
        ['Body', 'Published At'],
        ['', ''],
        ['Contenido de ejemplo', '22/05/2025 10:23:52'],
    ];

    $path = storage_path("framework/testing/$filename");

    \Maatwebsite\Excel\Facades\Excel::store(new class($rows) implements \Maatwebsite\Excel\Concerns\FromArray {
        private $rows;
        public function __construct($rows) { $this->rows = $rows; }
        public function array(): array { return $this->rows; }
    }, $filename, 'local');

    Excel::import(new PostsImport, $filename, 'local');

    expect(Post::count())->toBe(1)
        ->and(Post::first()->body)->toBe('Contenido de ejemplo')
        ->and(Post::first()->user_id)->toBe($user->id);
});

it('fails validation when body is missing', function () {
    $import = new PostsImport;

    $reflection = new ReflectionClass($import);
    $method = $reflection->getMethod('rules');
    $rules = $method->invoke($import);

    $validator = validator([
        '0' => '',
        '1' => '22/05/2025 10:23:52',
    ], $rules, $import->customValidationMessages());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('0'))->toBe(__('The body is required.'));
});
