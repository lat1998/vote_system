@extends('layout')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
        <h1 class="h3 fw-bold mb-0">Results: {{ $election->title }}</h1>
        <span class="badge bg-{{ $election->status === 'active' ? 'success' : ($election->status === 'completed' ? 'info' : 'secondary') }} px-3 py-2 fs-6">
            {{ ucfirst($election->status) }}
        </span>
    </div>
    @if($election->description)
        <p class="text-muted mb-0">{{ $election->description }}</p>
    @endif
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-bar-chart-line-fill text-primary me-1"></i> Vote Distribution</h6>
                <span class="badge bg-light text-muted border small">Overall Candidates</span>
            </div>
            <div class="card-body p-3">
                <div style="position: relative; height: 280px;">
                    <canvas id="resultsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle-fill text-primary me-1"></i> Election Summary</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-light border mb-2">
                    <span class="text-muted small">Total Votes Cast</span>
                    <h4 class="fw-bold mb-0 text-primary">{{ $totalVotes }}</h4>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-light border mb-2">
                    <span class="text-muted small">Registered Candidates</span>
                    <h5 class="fw-bold mb-0 text-dark">{{ $results->count() }}</h5>
                </div>
                <div class="p-3 rounded-3 bg-light border">
                    <small class="text-muted d-block mb-1">Voting Period</small>
                    <div class="small fw-semibold text-dark">
                        <i class="bi bi-calendar-event me-1"></i> {{ $election->start_date->format('M d, Y H:i') }}
                    </div>
                    <div class="small text-muted">
                        to {{ $election->end_date->format('M d, Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="h5 fw-bold mb-3"><i class="bi bi-trophy-fill text-warning me-1"></i> Breakdown by Position</h4>

@forelse($resultsByPosition as $position => $positionResults)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold">{{ $position }}</h6>
            <span class="badge bg-light text-secondary border">{{ $positionResults->count() }} candidates</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 80px;">Rank</th>
                        <th>Candidate</th>
                        <th style="width: 120px;">Votes</th>
                        <th style="width: 120px;">Share</th>
                        <th style="min-width: 180px;">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positionResults as $idx => $candidate)
                        <tr class="{{ $idx === 0 && $candidate->votes_count > 0 ? 'table-success bg-opacity-25' : '' }}">
                            <td>
                                @if($idx === 0 && $candidate->votes_count > 0)
                                    <span class="badge bg-warning text-dark"><i class="bi bi-award-fill"></i> #1</span>
                                @else
                                    <span class="badge bg-light text-secondary border">#{{ $idx + 1 }}</span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-dark">{{ $candidate->name }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary fs-6">{{ $candidate->votes_count }}</span>
                            </td>
                            <td>
                                <strong class="text-dark">{{ number_format($candidate->getVotePercentage(), 1) }}%</strong>
                            </td>
                            <td>
                                <div class="progress" style="height: 18px; border-radius: 6px; background-color: #e2e8f0;">
                                    <div class="progress-bar {{ $idx === 0 ? 'bg-success' : 'bg-primary' }}" 
                                         role="progressbar" 
                                         style="width: {{ $candidate->getVotePercentage() }}%;" 
                                         aria-valuenow="{{ $candidate->getVotePercentage() }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@empty
    <div class="card shadow-sm p-4 text-center text-muted bg-white mb-4">
        <i class="bi bi-bar-chart fs-1 d-block mb-1"></i>
        No votes cast yet in this election.
    </div>
@endforelse

<div class="mt-4 pt-2">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('resultsChart');
        if (!ctx) return;

        const labels = [
            @foreach($results as $candidate)
                '{{ addslashes($candidate->name) }}',
            @endforeach
        ];

        const votes = [
            @foreach($results as $candidate)
                {{ $candidate->votes_count }},
            @endforeach
        ];

        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Votes',
                    data: votes,
                    backgroundColor: 'rgba(37, 99, 235, 0.75)',
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 6,
                    maxBarThickness: 45
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, precision: 0 },
                        grid: { color: '#f1f5f9' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
