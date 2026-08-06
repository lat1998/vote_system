<?php

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

test('voting page shows candidates grouped by ballot position', function () {
    Artisan::call('migrate:fresh', ['--force' => true]);

    $user = User::factory()->create();
    $election = Election::factory()->create([
        'status' => 'active',
        'start_date' => now()->subDay(),
        'end_date' => now()->addDay(),
        'position_order' => "President\nVice President\nSenator",
    ]);

    Candidate::factory()->create([
        'election_id' => $election->id,
        'name' => 'Ana Cruz',
        'position' => 'President',
    ]);

    Candidate::factory()->create([
        'election_id' => $election->id,
        'name' => 'Ben Santos',
        'position' => 'Vice President',
    ]);

    Candidate::factory()->create([
        'election_id' => $election->id,
        'name' => 'Cora Lee',
        'position' => 'Senator',
    ]);

    $this->actingAs($user)
        ->get(route('votes.index', $election))
        ->assertOk()
        ->assertSee('President')
        ->assertSee('Ana Cruz')
        ->assertSee('Vice President')
        ->assertSee('Ben Santos')
        ->assertSee('Senator')
        ->assertSee('Cora Lee');
});
