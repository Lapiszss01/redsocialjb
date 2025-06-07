<?php

namespace App\Console\Commands;

use App\Models\Topic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TopTopicsOfDay extends Command
{
    protected $signature = 'topics:top-today {count=5}';
    protected $description = 'Muestra los topics más utilizados en posts creados hoy';

    public function handle()
    {
        $count = (int) $this->argument('count');

        $topTopics = Topic::topTopicsOfToday($count)->get();

        if ($topTopics->isEmpty()) {
            $this->warn('No hay topics utilizados hoy.');
            return;
        }

        $this->info("📚 TOP {$count} TOPICS DEL DÍA:");
        foreach ($topTopics as $index => $topic) {
            $this->info(($index + 1) . ". {$topic->name} - {$topic->usage_count} posts");
        }

        $this->info('Resumen de topics populares del día mostrado correctamente.');
    }
}
