<?php

namespace App\Console\Commands;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;


class SendDailyBestPostsCommand extends Command
{
    protected $signature = 'posts:send-daily-top';
    protected $description = 'Envía un resumen de los posts más populares del día a los usuarios.';

    public function handle()
    {
        $topPosts = Post::topLikedLastDay(5)->get();

        if ($topPosts->isEmpty()) {
            $this->warn('No hay posts populares para mostrar hoy.');
            return;
        }

        $this->info("📌 TOP 5 POSTS DEL DÍA:");
        foreach ($topPosts as $index => $post) {
            $this->info(($index + 1) . ". {$post->body} - {$post->likes_count} likes, {$post->children->count()} comentarios");
        }

        $this->info('Resumen de posts populares enviado.');
    }
}
