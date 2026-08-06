<?php

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('api elections endpoint is available', function () {
    $response = $this->getJson('/api/elections');

    $response->assertOk();
});

test('api vote endpoint requires authentication', function () {
    $user = User::factory()->create();
    $election = Election::factory()->create([
        'status' => 'active',
        'start_date' => now()->subDay(),
        'end_date' => now()->addDay(),
    ]);
    $candidate = Candidate::factory()->create(['election_id' => $election->id]);

    $response = $this->postJson('/api/votes', [
        'election_id' => $election->id,
        'candidate_id' => $candidate->id,
    ]);

    $response->assertUnauthorized();
});

test('api vote endpoint records a vote for authenticated users', function () {
    $user = User::factory()->create();
    $election = Election::factory()->create([
        'status' => 'active',
        'start_date' => now()->subDay(),
        'end_date' => now()->addDay(),
    ]);
    $candidate = Candidate::factory()->create(['election_id' => $election->id]);
    $token = $user->createToken('test')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/votes', [
            'election_id' => $election->id,
            'candidate_id' => $candidate->id,
        ]);

    $response->assertCreated();
    expect(Vote::where('user_id', $user->id)->exists())->toBeTrue();
});

test('api admin routes reject non-admin users', function () {
    $voter = User::factory()->voter()->create();
    $token = $voter->createToken('test')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/admin/elections', [
            'title' => 'Unauthorized Election',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addWeek()->toDateString(),
        ]);

    $response->assertForbidden();
});

test('api login endpoint accepts a raw json body', function () {
    $user = User::factory()->create([
        'email' => 'postman@example.com',
        'password' => bcrypt('secret123'),
    ]);

    $response = $this->call(
        'POST',
        '/api/login',
        [],
        [],
        [],
        ['CONTENT_TYPE' => 'application/json'],
        json_encode([
            'email' => $user->email,
            'password' => 'secret123',
        ])
    );

    $response->assertOk();
    $response->assertJsonPath('user.email', $user->email);
});
