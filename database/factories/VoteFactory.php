<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'election_id' => Election::factory(),
            'candidate_id' => Candidate::factory(),
            'user_id' => User::factory(),
            'qr_token' => strtoupper('VOTE_' . uniqid()),
            'voted_at' => now(),
        ];
    }
}
