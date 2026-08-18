<?php

namespace App\Http\Controllers\Api;

use App\Models\Election;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * GET /api/elections - List all elections
     */
    public function getElections(): JsonResponse
    {
        $elections = Election::with('candidates')->get();
        return response()->json($elections);
    }

    /**
     * GET /api/elections/{id} - Get specific election
     */
    public function getElection(Election $election): JsonResponse
    {
        return response()->json($election->load('candidates'));
    }

    public function storeElection(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => ['nullable', 'in:draft,active,completed'],
        ]);

        $validated['election_code'] = strtoupper(uniqid('ELEC_'));
        $validated['status'] = $validated['status'] ?? 'draft';

        $election = Election::create($validated);

        return response()->json($election, 201);
    }

    public function updateElection(Request $request, Election $election): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['sometimes', 'required', 'date', 'after:start_date'],
            'status' => ['sometimes', 'required', 'in:draft,active,completed'],
        ]);

        $election->update($validated);

        return response()->json($election->fresh());
    }

    public function deleteElection(Election $election): JsonResponse
    {
        $election->delete();

        return response()->json(['message' => 'Election deleted successfully']);
    }

    /**
     * GET /api/candidates - List all candidates
     */
    public function getCandidates(): JsonResponse
    {
        $candidates = Candidate::with('election')->withCount('votes')->get();
        return response()->json($candidates);
    }

    public function getCandidate(Candidate $candidate): JsonResponse
    {
        return response()->json($candidate->load(['election'])->loadCount('votes'));
    }

    public function storeCandidate(Request $request, Election $election): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['position'] = $validated['position'] ?? 'Unassigned';
        $candidate = $election->candidates()->create($validated);

        return response()->json($candidate, 201);
    }

    public function updateCandidate(Request $request, Candidate $candidate): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'position' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        $candidate->update($validated);

        return response()->json($candidate->fresh());
    }

    public function deleteCandidate(Candidate $candidate): JsonResponse
    {
        $candidate->delete();

        return response()->json(['message' => 'Candidate deleted successfully']);
    }

    /**
     * GET /api/elections/{election}/candidates - Get candidates for election
     */
    public function getCandidatesByElection(Election $election): JsonResponse
    {
        $candidates = $election->candidates()->withCount('votes')->get();
        return response()->json($candidates);
    }

    /**
     * POST /api/votes - Cast a vote
     */
    public function castVote(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'election_id' => ['required', 'exists:elections,id'],
            'candidate_id' => ['required', 'exists:candidates,id'],
        ]);

        $election = Election::find($validated['election_id']);

        if (!$election) {
            return response()->json(['error' => 'Election not found'], 404);
        }

        // Check if election is active
        if (!$election->isActive()) {
            return response()->json(['error' => 'Election is not active'], 400);
        }

        $voterId = auth()->id();

        // Check if user already voted
        $alreadyVoted = Vote::where('election_id', $election->id)
                           ->where('user_id', $voterId)
                           ->exists();

        if ($alreadyVoted) {
            return response()->json(['error' => 'You have already voted'], 400);
        }

        $vote = Vote::create([
            'election_id' => $validated['election_id'],
            'candidate_id' => $validated['candidate_id'],
            'user_id' => $voterId,
            'qr_token' => strtoupper(uniqid('VOTE_')),
        ]);

        return response()->json([
            'message' => 'Vote recorded successfully',
            'vote' => $vote
        ], 201);
    }

    /**
     * GET /api/results/{election} - Get election results
     */
    public function getResults(Election $election): JsonResponse
    {
        $results = $election->getVoteResults()->map(function ($candidate) {
            return [
                'id' => $candidate->id,
                'name' => $candidate->name,
                'votes' => $candidate->votes_count,
                'percentage' => $candidate->getVotePercentage(),
            ];
        });

        return response()->json([
            'election' => [
                'id' => $election->id,
                'title' => $election->title,
                'status' => $election->status,
                'total_votes' => $election->getTotalVotes(),
            ],
            'results' => $results,
        ]);
    }
}
