<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        // Create regular voters
        $voters = User::factory(10)->voter()->create();

        // Create elections
        $election1 = Election::factory()->active()->create([
            'title' => 'Presidential Election 2026',
            'description' => 'Vote for your preferred presidential candidate',
        ]);

        $election2 = Election::factory()->draft()->create([
            'title' => 'Board of Directors Election',
            'description' => 'Select board members for the upcoming term',
        ]);

        $election3 = Election::factory()->completed()->create([
            'title' => 'Previous Election Results',
            'description' => 'Results from the previous voting round',
        ]);

        // Create candidates for election 1
        $candidate1 = Candidate::factory()->create([
            'election_id' => $election1->id,
            'name' => 'John Doe',
            'bio' => 'Experienced politician with 20 years in public service.',
            'position' => 1,
        ]);

        $candidate2 = Candidate::factory()->create([
            'election_id' => $election1->id,
            'name' => 'Jane Smith',
            'bio' => 'Community leader dedicated to social development.',
            'position' => 2,
        ]);

        $candidate3 = Candidate::factory()->create([
            'election_id' => $election1->id,
            'name' => 'Robert Johnson',
            'bio' => 'Business expert with innovative solutions.',
            'position' => 3,
        ]);

        // Create candidates for election 2
        $candidate4 = Candidate::factory()->create([
            'election_id' => $election2->id,
            'name' => 'Alice Brown',
            'bio' => 'Finance expert with proven track record.',
            'position' => 1,
        ]);

        $candidate5 = Candidate::factory()->create([
            'election_id' => $election2->id,
            'name' => 'Michael Wilson',
            'bio' => 'Strategy consultant and board member.',
            'position' => 2,
        ]);

        // Create candidates for election 3
        $candidate6 = Candidate::factory()->create([
            'election_id' => $election3->id,
            'name' => 'Sarah Davis',
            'bio' => 'Previous term board member.',
            'position' => 1,
        ]);

        // Create some votes for active election
        foreach ($voters->slice(0, 7) as $voter) {
            Vote::factory()->create([
                'election_id' => $election1->id,
                'candidate_id' => [$candidate1->id, $candidate2->id, $candidate3->id][rand(0, 2)],
                'user_id' => $voter->id,
            ]);
        }

        // Create votes for completed election
        Vote::factory()->create([
            'election_id' => $election3->id,
            'candidate_id' => $candidate6->id,
            'user_id' => $voters->first()->id,
        ]);
    }
}
