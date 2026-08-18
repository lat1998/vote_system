<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'elections=' . App\Models\Election::count() . PHP_EOL;
echo 'candidates=' . App\Models\Candidate::count() . PHP_EOL;

$election = App\Models\Election::first();
if ($election) {
    echo 'first_election_id=' . $election->id . PHP_EOL;
    echo 'first_election_status=' . $election->status . PHP_EOL;
    $candidate = $election->candidates()->first();
    if ($candidate) {
        echo 'first_candidate_id=' . $candidate->id . PHP_EOL;
    }
}
