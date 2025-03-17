<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CleanupUnusedImagesJob;
use Illuminate\Support\Facades\Log;

class CleanupUnusedImages extends Command
{
    protected $signature = 'cleanup:unused-images';

    protected $description = 'Elimina las imágenes no utilizadas asociadas a los posts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        CleanupUnusedImagesJob::dispatch();
        $this->info('Job de limpieza de imágenes ejecutado.');
    }
}
