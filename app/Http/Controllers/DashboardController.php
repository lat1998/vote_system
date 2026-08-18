<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Vote;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index(): View
    {
        if (auth()->user()->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->voterDashboard();
    }

    /**
     * Display the authenticated user's profile.
     */
    public function profile(): View
    {
        $user = auth()->user();
        $qrCode = base64_encode(QrCode::format('svg')->size(220)->generate((string) $user->id));

        return view('dashboard.profile', compact('user', 'qrCode'));
    }

    /**
     * Display admin dashboard with statistics.
     */
    private function adminDashboard(): View
    {
        $totalElections = Election::count();
        $activeElections = Election::where('status', 'active')->count();
        $completedElections = Election::where('status', 'completed')->count();
        $totalVotes = Vote::count();

        $recentElections = Election::latest()->take(5)->get();
        $topCandidates = \App\Models\Candidate::with('election')
                                              ->withCount('votes')
                                              ->orderBy('votes_count', 'desc')
                                              ->take(5)
                                              ->get();

        return view('dashboard.admin', compact(
            'totalElections',
            'activeElections',
            'completedElections',
            'totalVotes',
            'recentElections',
            'topCandidates'
        ));
    }

    /**
     * Display voter dashboard with available elections.
     */
    private function voterDashboard(): View
    {
        $votedElectionIds = Vote::where('user_id', auth()->id())->pluck('election_id')->toArray();

        $availableElections = Election::where('status', 'active')
            ->whereNotIn('id', $votedElectionIds)
            ->get()
            ->filter(fn ($election) => $election->isActive())
            ->values();

        $votedElections = auth()->user()->votedElections()->get();

        // Completed elections that the user did not participate in (prevents duplicate cards)
        $completedElections = Election::where('status', 'completed')
            ->whereNotIn('id', $votedElectionIds)
            ->get();

        return view('dashboard.voter', compact(
            'availableElections',
            'votedElections',
            'completedElections'
        ));
    }
}
