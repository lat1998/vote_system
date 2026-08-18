<?php

namespace Database\Factories;

use App\Models\Election;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CandidateFactory extends Factory
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
            'name' => fake()->name(),
            'bio' => fake()->paragraph(),
            'image' => null,
            'position' => fake()->numberBetween(1, 10),
        ];
    }
}
