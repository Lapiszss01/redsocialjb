<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class CleanupUnusedImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function handle()
    {
        $files = Storage::disk('public')->files('uploads');

        $usedImages = Post::pluck('image_url')->map(function($url) {
            return basename(parse_url($url, PHP_URL_PATH));
        })->toArray();

        foreach ($files as $file) {
            if (!in_array(basename($file), $usedImages)) {
                Storage::disk('public')->delete($file);
            }
        }
    }
}
