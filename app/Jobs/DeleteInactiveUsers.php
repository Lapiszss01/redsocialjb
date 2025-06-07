<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteInactiveUsers
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $months = 12;
        $cutoffDate = Carbon::now()->subMonths($months);

        $usersToDelete = User::whereNotIn('id', function ($query) use ($cutoffDate) {
            $query->select('user_id')
                ->from('sessions')
                ->where('last_activity', '>=', $cutoffDate);
        })->get();

        Log::info("Lista users: {$usersToDelete}");

        foreach ($usersToDelete as $user) {
            Log::info("Eliminando usuario inactivo: {$user->email}");
            $user->delete();
        }
    }
}
