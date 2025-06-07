<?php

use App\Jobs\DeleteInactiveUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

it('deletes users inactive for more than 6 months', function () {
    // Arrange
    $inactiveUser = User::factory()->create();
    $activeUser = User::factory()->create();

    \DB::table('sessions')->insert([
        'id' => Str::uuid()->toString(),
        'user_id' => $activeUser->id,
        'last_activity' => Carbon::now()->timestamp,
        'payload' => '',
    ]);

    // Act
    Log::spy();
    (new DeleteInactiveUsers())->handle();

    // Assert
    $this->assertDatabaseMissing('users', ['id' => $inactiveUser->id]);
    Log::shouldHaveReceived('info')->withArgs(fn($message) => str_contains($message, $inactiveUser->email));
});
