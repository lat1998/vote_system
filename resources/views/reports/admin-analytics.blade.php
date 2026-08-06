@extends('layout')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Admin Analytics</h1>
        <a href="{{ route('reports.export-analytics') }}" class="btn btn-success">
            📊 Export as CSV
        </a>
    </div>
</div>

<!-- Key Metrics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Total Elections</h6>
                <h2 class="mb-0">{{ $totalElections }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Active Elections</h6>
                <h2 class="mb-0">{{ $activeElections }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Completed Elections</h6>
                <h2 class="mb-0">{{ $completedElections }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="card-title">Draft Elections</h6>
                <h2 class="mb-0">{{ $draftElections }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Overall Statistics -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h4>Total Votes Cast</h4>
                <h1 class="text-primary">{{ $totalVotes }}</h1>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h4>Total Candidates</h4>
                <h1 class="text-success">{{ $totalCandidates }}</h1>
            </div>
        </div>
    </div>
</div>

<!-- Election Details -->
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">Election Statistics</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Election Title</th>
                    <th>Status</th>
                    <th>Candidates</th>
                    <th>Total Votes</th>
                    <th>Avg Votes/Candidate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($electionStats as $stat)
                    <tr>
                        <td><strong>{{ $stat['title'] }}</strong></td>
                        <td>
                            <span class="badge bg-{{ $stat['status'] === 'active' ? 'success' : ($stat['status'] === 'completed' ? 'info' : 'secondary') }}">
                                {{ ucfirst($stat['status']) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $stat['candidate_count'] }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning">{{ $stat['total_votes'] }}</span>
                        </td>
                        <td>
                            @if($stat['candidate_count'] > 0)
                                {{ number_format($stat['total_votes'] / $stat['candidate_count'], 2) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No elections found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Summary Section -->
<div class="mt-4 p-3 bg-light rounded">
    <h5>Summary</h5>
    <ul class="list-unstyled">
        <li><strong>Total System Elections:</strong> {{ $totalElections }}</li>
        <li><strong>Elections in Progress:</strong> {{ $activeElections }}</li>
        <li><strong>Completed Elections:</strong> {{ $completedElections }}</li>
        <li><strong>Overall Participation:</strong> {{ $totalVotes }} votes across all elections</li>
        <li><strong>Average Candidates per Election:</strong> 
            @if($totalElections > 0)
                {{ number_format($totalCandidates / $totalElections, 2) }}
            @else
                0
            @endif
        </li>
    </ul>
</div>

<div class="mt-4">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection
