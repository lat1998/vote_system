<?php

use App\Models\Election;
use Illuminate\Support\Facades\Artisan;

test('an election marked active remains available to voters even before its scheduled start date', function () {
    Artisan::call('migrate:fresh', ['--force' => true]);

    $election = Election::factory()->create([
        'status' => 'active',
        'start_date' => now()->addDay(),
        'end_date' => now()->addWeek(),
    ]);

    expect($election->isActive())->toBeTrue();
});
