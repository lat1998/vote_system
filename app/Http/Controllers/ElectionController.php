<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ElectionController extends Controller
{
    /**
     * Display a listing of elections.
     */
    public function index(): View
    {
        $elections = Election::withCount('candidates')->latest()->paginate(10);
        return view('elections.index', compact('elections'));
    }

    /**
     * Show the form for creating a new election.
     */
    public function create(): View
    {
        return view('elections.create');
    }

    /**
     * Store a newly created election in database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        $validated['election_code'] = strtoupper(uniqid('ELEC_'));
        $validated['status'] = 'draft';

        Election::create($validated);

        return redirect()->route('elections.index')
                       ->with('success', 'Election created successfully');
    }

    /**
     * Display the specified election.
     */
    public function show(Election $election): View
    {
        $candidates = $election->candidates()->withCount('votes')->get();
        $totalVotes = $election->getTotalVotes();
        return view('elections.show', compact('election', 'candidates', 'totalVotes'));
    }

    /**
     * Show the form for editing the election.
     */
    public function edit(Election $election): View
    {
        return view('elections.edit', compact('election'));
    }

    /**
     * Update the specified election in database.
     */
    public function update(Request $request, Election $election): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'status' => ['required', 'in:draft,active,completed'],
        ]);

        $election->update($validated);

        return redirect()->route('elections.show', $election)
                       ->with('success', 'Election updated successfully');
    }

    /**
     * Remove the specified election from database.
     */
    public function destroy(Election $election): RedirectResponse
    {
        $election->delete();

        return redirect()->route('elections.index')
                       ->with('success', 'Election deleted successfully');
    }

    /**
     * Activate an election.
     */
    public function activate(Election $election): RedirectResponse
    {
        $election->update(['status' => 'active']);

        return redirect()->route('elections.show', $election)
                       ->with('success', 'Election activated successfully');
    }

    /**
     * Complete an election.
     */
    public function complete(Election $election): RedirectResponse
    {
        $election->update(['status' => 'completed']);

        return redirect()->route('elections.show', $election)
                       ->with('success', 'Election completed successfully');
    }
}
