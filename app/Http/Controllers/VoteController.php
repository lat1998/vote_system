<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VoteController extends Controller
{
    /**
     * Display voting interface for an election.
     */
    public function index(Election $election): View
    {
        // Check if user has already voted
        $hasVoted = Vote::where('election_id', $election->id)
                        ->where('user_id', auth()->id())
                        ->exists();

        $positionOrder = collect(explode(PHP_EOL, $election->position_order ?? ''))
            ->map(fn ($value) => trim($value))
            ->filter()
            ->values()
            ->all();

        if (empty($positionOrder)) {
            $positionOrder = ['President', 'Vice President', 'Senator', 'Councilor', 'Mayor', 'Unassigned'];
        }

        $candidatesByPosition = $election->candidates()
            ->get()
            ->groupBy(fn ($candidate) => $candidate->position ?: 'Unassigned')
            ->map(fn ($candidates) => $candidates->sortBy(fn ($candidate) => strtolower($candidate->name))->values());

        $orderedPositions = collect($positionOrder)
            ->merge($candidatesByPosition->keys()->diff($positionOrder))
            ->filter()
            ->values();

        $candidatesByPosition = $orderedPositions->mapWithKeys(function ($position) use ($candidatesByPosition) {
            return [$position => $candidatesByPosition->get($position, collect())];
        });

        return view('votes.index', compact('election', 'candidatesByPosition', 'hasVoted'));
    }

    /**
     * Cast a vote.
     */
    public function store(Request $request, Election $election): RedirectResponse
    {
        // Validate election is active
        if (!$election->isActive()) {
            return back()->withErrors(['error' => 'This election is not active']);
        }

        // Check if user already voted
        $alreadyVoted = Vote::where('election_id', $election->id)
                           ->where('user_id', auth()->id())
                           ->exists();

        if ($alreadyVoted) {
            return back()->withErrors(['error' => 'You have already voted in this election']);
        }

        $validated = $request->validate([
            'candidate_id' => ['required', 'exists:candidates,id'],
        ]);

        // Verify candidate belongs to this election
        $candidate = $election->candidates()->findOrFail($validated['candidate_id']);

        $vote = Vote::create([
            'election_id' => $election->id,
            'candidate_id' => $candidate->id,
            'user_id' => auth()->id(),
            'qr_token' => $this->generateQRToken(),
        ]);

        return redirect()->route('votes.confirmation', ['election' => $election, 'vote' => $vote])
                       ->with('success', 'Your vote has been recorded successfully');
    }

    /**
     * Show a confirmation page for a vote.
     */
    public function confirmation(Election $election, Vote $vote): View
    {
        if ($vote->election_id !== $election->id || $vote->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('votes.confirmation', compact('election', 'vote'));
    }

    /**
     * View results for an election.
     */
    public function results(Election $election): View
    {
        $results = $election->getVoteResults();
        $positionOrder = collect(explode(PHP_EOL, $election->position_order ?? ''))
            ->map(fn ($value) => trim($value))
            ->filter()
            ->values()
            ->all();

        if (empty($positionOrder)) {
            $positionOrder = ['President', 'Vice President', 'Senator', 'Councilor', 'Mayor', 'Unassigned'];
        }

        $resultsByPosition = $results->groupBy(function ($candidate) {
            return $candidate->position ?: 'Unassigned';
        })->map(function ($candidates) {
            return $candidates->sortByDesc('votes_count')->sortBy(function ($candidate) {
                return $candidate->name;
            });
        })->sortBy(function ($candidates, $position) use ($positionOrder) {
            $index = array_search($position, $positionOrder, true);
            return $index !== false ? $index : 999;
        });
        $totalVotes = $election->getTotalVotes();

        return view('votes.results', compact('election', 'results', 'resultsByPosition', 'totalVotes'));
    }

    /**
     * Generate a unique QR token for vote verification.
     */
    private function generateQRToken(): string
    {
        return strtoupper(uniqid('VOTE_'));
    }
}
