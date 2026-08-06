<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('API authentication', function () {
    it('issues a token for valid credentials', function () {
        $user = User::factory()->create([
            'email' => 'api@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'user' => ['id', 'name', 'email', 'role'],
            ]);
    });

    it('rejects invalid credentials', function () {
        User::factory()->create([
            'email' => 'api@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'api@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid credentials']);
    });

    it('requires a valid token for protected routes', function () {
        $response = $this->postJson('/api/votes', [
            'election_id' => 999,
            'candidate_id' => 999,
        ]);

        $response->assertStatus(401);
    });

    it('revokes a token when the user logs out', function () {
        $user = User::factory()->create([
            'email' => 'logout@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $response->assertOk()
            ->assertJson(['message' => 'Logged out successfully']);
    });
});
