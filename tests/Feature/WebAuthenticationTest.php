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

test('user registration assigns voter role and generates voter id', function () {
    $response = $this->post('/register', [
        'name' => 'New Voter',
        'email' => 'newvoter@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/login');
    $user = User::where('email', 'newvoter@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('voter');
    expect($user->voter_id)->toStartWith('VOTER_');
});

test('voter dashboard does not duplicate completed election if user voted in it', function () {
    $user = User::factory()->create();
    $election = Election::factory()->create([
        'title' => 'Sample Completed Election',
        'status' => 'completed',
        'start_date' => now()->subDays(5),
        'end_date' => now()->subDay(),
    ]);
    $candidate = \App\Models\Candidate::factory()->create(['election_id' => $election->id]);
    \App\Models\Vote::factory()->create([
        'election_id' => $election->id,
        'candidate_id' => $candidate->id,
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get('/dashboard');
    $response->assertOk();
    // Election title should appear only once on the page
    expect(substr_count($response->getContent(), 'Sample Completed Election'))->toBe(1);
});

test('admin can access analytics and reports', function () {
    $admin = User::factory()->admin()->create();
    $election = Election::factory()->create(['status' => 'active']);

    $responseAnalytics = $this->actingAs($admin)->get('/admin/analytics');
    $responseAnalytics->assertOk();

    $responseReports = $this->actingAs($admin)->get("/elections/{$election->id}/reports");
    $responseReports->assertOk();
});

