<?php

namespace App\Services;

use App\Models\Election;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportService
{
    /**
     * Export election results as CSV
     */
    public static function exportResultsAsCSV(Election $election): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="election_results_' . $election->id . '.csv"',
        ];

        $callback = function () use ($election) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Election Results: ' . $election->title]);
            fputcsv($file, ['Generated on', date('Y-m-d H:i:s')]);
            fputcsv($file, []);
            
            fputcsv($file, ['Candidate Name', 'Votes', 'Percentage']);
            
            $results = $election->getVoteResults();
            foreach ($results as $candidate) {
                fputcsv($file, [
                    $candidate->name,
                    $candidate->votes_count ?? 0,
                    number_format($candidate->getVotePercentage(), 2) . '%',
                ]);
            }
            
            fputcsv($file, []);
            fputcsv($file, ['Total Votes', $election->getTotalVotes()]);
            
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * Export election results as JSON
     */
    public static function exportResultsAsJSON(Election $election): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="election_results_' . $election->id . '.json"',
        ];

        $results = $election->getVoteResults()->map(function ($candidate) {
            return [
                'name' => $candidate->name,
                'votes' => $candidate->votes_count ?? 0,
                'percentage' => number_format($candidate->getVotePercentage(), 2),
            ];
        });

        $data = [
            'election' => [
                'id' => $election->id,
                'title' => $election->title,
                'description' => $election->description,
                'status' => $election->status,
                'start_date' => $election->start_date->toDateTimeString(),
                'end_date' => $election->end_date->toDateTimeString(),
                'total_votes' => $election->getTotalVotes(),
            ],
            'results' => $results,
            'generated_at' => now()->toDateTimeString(),
        ];

        return response()->streamDownload(
            fn () => print json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'election_results_' . $election->id . '.json',
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Export election results as HTML/PDF-friendly format
     */
    public static function generateResultsHTML(Election $election): string
    {
        $results = $election->getVoteResults();
        $totalVotes = $election->getTotalVotes();

        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Election Results - {$election->title}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .info {
            background-color: #f9f9f9;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .progress-bar {
            background-color: #007bff;
            height: 20px;
            border-radius: 3px;
        }
        .winner {
            background-color: #d4edda;
            font-weight: bold;
        }
        .footer {
            text-align: right;
            color: #666;
            font-size: 12px;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Election Results: {$election->title}</h1>
        
        <div class="info">
            <p><strong>Election Code:</strong> {$election->election_code}</p>
            <p><strong>Status:</strong> {$election->status}</p>
            <p><strong>Period:</strong> {$election->start_date->format('M d, Y H:i')} to {$election->end_date->format('M d, Y H:i')}</p>
        </div>

        <div class="info">
            <p><strong>Total Votes Cast:</strong> {$totalVotes}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Candidate Name</th>
                    <th>Votes</th>
                    <th>Percentage</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
HTML;

        $rank = 1;
        foreach ($results as $candidate) {
            $percentage = $candidate->getVotePercentage();
            $rowClass = $rank === 1 ? 'winner' : '';
            $html .= <<<HTML
                <tr class="{$rowClass}">
                    <td>#{$rank}</td>
                    <td>{$candidate->name}</td>
                    <td>{$candidate->votes_count}</td>
                    <td>$percentage%</td>
                    <td><div class="progress-bar" style="width: {$percentage}%;"></div></td>
                </tr>
HTML;
            $rank++;
        }

        $html .= <<<HTML
            </tbody>
        </table>

        <div class="footer">
            <p>Generated on: {date('Y-m-d H:i:s')}</p>
        </div>
    </div>
</body>
</html>
HTML;

        return $html;
    }

    /**
     * Get results as simple array for API
     */
    public static function getResultsArray(Election $election): array
    {
        $results = $election->getVoteResults()->map(function ($candidate) {
            return [
                'id' => $candidate->id,
                'name' => $candidate->name,
                'votes' => $candidate->votes_count ?? 0,
                'percentage' => number_format($candidate->getVotePercentage(), 2),
            ];
        });

        return [
            'election' => [
                'id' => $election->id,
                'title' => $election->title,
                'status' => $election->status,
                'total_votes' => $election->getTotalVotes(),
            ],
            'results' => $results,
        ];
    }
}
