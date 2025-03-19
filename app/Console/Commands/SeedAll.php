<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta todos los seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Ejecutando seeders...');
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);
        $this->info('DatabaseSeeder ejecutado');

        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        $this->info('RoleSeeder ejecutado');

        $this->info('Todos los seeders han sido ejecutados');
    }
}
