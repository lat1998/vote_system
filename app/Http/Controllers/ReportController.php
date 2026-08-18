<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Show reports page for an election
     */
    public function index(Election $election): View
    {
        $totalVotes = $election->getTotalVotes();
        $results = $election->getVoteResults();

        return view('reports.index', compact('election', 'results', 'totalVotes'));
    }

    /**
     * Export results as CSV
     */
    public function exportCSV(Election $election)
    {
        return ReportService::exportResultsAsCSV($election);
    }

    /**
     * Export results as JSON
     */
    public function exportJSON(Election $election)
    {
        return ReportService::exportResultsAsJSON($election);
    }

    /**
     * View results as HTML (can be printed or converted to PDF)
     */
    public function viewHTML(Election $election): View
    {
        $html = ReportService::generateResultsHTML($election);
        return view('reports.html', compact('html'));
    }

    /**
     * Generate admin analytics report
     */
    public function adminAnalytics(): View
    {
        $totalElections = Election::count();
        $activeElections = Election::where('status', 'active')->count();
        $completedElections = Election::where('status', 'completed')->count();
        $draftElections = Election::where('status', 'draft')->count();

        $totalVotes = \App\Models\Vote::count();
        $totalCandidates = \App\Models\Candidate::count();

        $electionStats = Election::with('candidates')
                                ->get()
                                ->map(function ($election) {
                                    return [
                                        'title' => $election->title,
                                        'total_votes' => $election->getTotalVotes(),
                                        'candidate_count' => $election->candidates()->count(),
                                        'status' => $election->status,
                                    ];
                                });

        return view('reports.admin-analytics', compact(
            'totalElections',
            'activeElections',
            'completedElections',
            'draftElections',
            'totalVotes',
            'totalCandidates',
            'electionStats'
        ));
    }

    /**
     * Export admin analytics as CSV
     */
    public function exportAnalyticsCSV()
    {
        $filename = 'voting_system_analytics_' . date('Y-m-d') . '.csv';

        return response()->stream(function () {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['Voting System Analytics Report']);
            fputcsv($file, ['Generated on', date('Y-m-d H:i:s')]);
            fputcsv($file, []);

            // Summary stats
            fputcsv($file, ['SUMMARY STATISTICS']);
            fputcsv($file, ['Total Elections', \App\Models\Election::count()]);
            fputcsv($file, ['Active Elections', \App\Models\Election::where('status', 'active')->count()]);
            fputcsv($file, ['Completed Elections', \App\Models\Election::where('status', 'completed')->count()]);
            fputcsv($file, ['Draft Elections', \App\Models\Election::where('status', 'draft')->count()]);
            fputcsv($file, ['Total Votes Cast', \App\Models\Vote::count()]);
            fputcsv($file, ['Total Candidates', \App\Models\Candidate::count()]);
            fputcsv($file, []);

            // Election details
            fputcsv($file, ['ELECTION DETAILS']);
            fputcsv($file, ['Election Title', 'Votes Cast', 'Candidates', 'Status']);

            $elections = \App\Models\Election::with('candidates')->get();
            foreach ($elections as $election) {
                fputcsv($file, [
                    $election->title,
                    $election->getTotalVotes(),
                    $election->candidates()->count(),
                    $election->status,
                ]);
            }

            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
