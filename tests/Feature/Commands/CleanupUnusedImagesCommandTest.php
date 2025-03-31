<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use function Pest\Laravel\artisan;
use App\Jobs\CleanupUnusedImagesJob;

it('dispatches the cleanup job', function () {
    Bus::fake();

    artisan('cleanup:unused-images')
        ->expectsOutput('Job de limpieza de imágenes ejecutado.');

    Bus::assertDispatched(CleanupUnusedImagesJob::class);
});


