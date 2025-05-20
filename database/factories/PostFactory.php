<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => fake()->paragraph(),
            'parent_id' => null,
            'image_url' => function () {
                $uploadPath = storage_path('app/public/uploads');

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $fileName = fake()->uuid() . '.jpg';
                $fullPath = $uploadPath . '/' . $fileName;
                $width = 640;
                $height = 480;
                $image = imagecreatetruecolor($width, $height);
                $bgColor = imagecolorallocate($image, rand(100,255), rand(100,255), rand(100,255));
                imagefill($image, 0, 0, $bgColor);
                $textColor = imagecolorallocate($image, 0, 0, 0);
                $text = Str::upper(Str::random(5));
                imagestring($image, 5, rand(10, $width - 100), rand(10, $height - 20), $text, $textColor);
                imagejpeg($image, $fullPath);
                imagedestroy($image);

                return 'uploads/' . $fileName;
            },
            'published_at' => fake()->date(),
        ];
    }
}
