<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CandidateController extends Controller
{
    /**
     * Display candidates for an election.
     */
    public function index(Election $election): View
    {
        $candidates = $election->candidates()->paginate(10);
        return view('candidates.index', compact('election', 'candidates'));
    }

    /**
     * Show the form for creating a new candidate.
     */
    public function create(Election $election): View
    {
        return view('candidates.create', compact('election'));
    }

    /**
     * Store a newly created candidate in database.
     */
    public function store(Request $request, Election $election): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'position' => ['required', 'string', 'max:255'],
        ]);

        $election->candidates()->create($validated);

        return redirect()->route('elections.candidates.index', $election)
                       ->with('success', 'Candidate created successfully');
    }

    /**
     * Display the specified candidate.
     */
    public function show(Election $election, Candidate $candidate): View
    {
        $voteCount = $candidate->getVoteCount();
        $votePercentage = $candidate->getVotePercentage();
        
        return view('candidates.show', compact('candidate', 'election', 'voteCount', 'votePercentage'));
    }

    /**
     * Show the form for editing the candidate.
     */
    public function edit(Election $election, Candidate $candidate): View
    {
        // Added 'election' to compact in case your view needs it for the form action URL
        return view('candidates.edit', compact('election', 'candidate'));
    }

    /**
     * Update the specified candidate in database.
     */
    public function update(Request $request, Election $election, Candidate $candidate): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'position' => ['required', 'string', 'max:255'],
        ]);

        $candidate->update($validated);

        return redirect()->route('elections.candidates.show', [$election, $candidate])
                       ->with('success', 'Candidate updated successfully');
    }

    /**
     * Remove the specified candidate from database.
     */
    public function destroy(Election $election, Candidate $candidate): RedirectResponse
    {
        $candidate->delete();

        return redirect()->route('elections.candidates.index', $election)
                       ->with('success', 'Candidate deleted successfully');
    }
}