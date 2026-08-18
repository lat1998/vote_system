<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ElectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 day', '+30 days');
        $endDate = (clone $startDate)->modify('+7 days');

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['draft', 'active', 'completed']),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'election_code' => strtoupper('ELEC_' . uniqid()),
        ];
    }

    /**
     * Indicate that the election is in draft status.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }

    /**
     * Indicate that the election is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);
    }

    /**
     * Indicate that the election is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'start_date' => now()->subDays(7),
            'end_date' => now()->subDays(1),
        ]);
    }
}
