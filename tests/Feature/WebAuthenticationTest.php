<?php

use App\Models\Election;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('dashboard requires login', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});

test('vote page requires login', function () {
    $election = Election::factory()->active()->create([
        'start_date' => now()->subDay(),
        'end_date' => now()->addDay(),
    ]);

    $response = $this->get("/elections/{$election->id}/vote");

    $response->assertRedirect('/login');
});

