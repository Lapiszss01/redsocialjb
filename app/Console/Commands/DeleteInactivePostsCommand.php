<?php

namespace App\Console\Commands;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;


class DeleteInactivePostsCommand extends Command
{
    protected $signature = 'posts:delete-inactive {days=30}';
    protected $description = 'Elimina posts sin likes después de un tiempo determinado.';

    public function handle()
    {
        $days = $this->argument('days');
        $thresholdDate = Carbon::now()->subDays($days);

        $deleted = Post::where('created_at', '<', $thresholdDate)
            ->whereDoesntHave('likes')
            ->delete();

        $this->info("Se eliminaron {$deleted} posts inactivos.");
    }
}
