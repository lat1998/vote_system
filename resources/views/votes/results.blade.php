@extends('layout')

@section('content')
<h1 class="mb-4">Results for {{ $election->title }}</h1>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-4">Vote Results</h5>
                <canvas id="resultsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Statistics</h5>
                <div class="mb-3">
                    <strong>Total Votes Cast:</strong>
                    <span class="badge bg-primary fs-6">{{ $totalVotes }}</span>
                </div>
                <div class="mb-3">
                    <strong>Total Candidates:</strong>
                    <span class="badge bg-info fs-6">{{ $results->count() }}</span>
                </div>
                <div class="mb-3">
                    <strong>Election Status:</strong>
                    <span class="badge bg-{{ $election->status === 'active' ? 'success' : 'secondary' }} fs-6">
                        {{ ucfirst($election->status) }}
                    </span>
                </div>
                <hr>
                <p class="mb-0 text-muted">
                    <strong>End Date:</strong><br>
                    {{ $election->end_date->format('M d, Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>

@forelse($resultsByPosition as $position => $positionResults)
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ $position }}</h5>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Candidate</th>
                            <th>Votes</th>
                            <th>Percentage</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($positionResults as $candidate)
                            <tr>
                                <td><strong>{{ $candidate->name }}</strong></td>
                                <td>
                                    <span class="badge bg-primary">{{ $candidate->votes_count }}</span>
                                </td>
                                <td>{{ number_format($candidate->getVotePercentage(), 2) }}%</td>
                                <td>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar bg-success" style="width: {{ $candidate->getVotePercentage() }}%">
                                            {{ number_format($candidate->getVotePercentage(), 1) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@empty
    <div class="card shadow-sm">
        <div class="card-body text-center text-muted py-4">No votes cast yet</div>
    </div>
@endforelse

<div class="mt-4">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('resultsChart').getContext('2d');
    const data = {
        labels: [
            @forelse($results as $candidate)
                '{{ $candidate->name }}',
            @empty
            @endforelse
        ],
        datasets: [{
            label: 'Votes',
            data: [
                @forelse($results as $candidate)
                    {{ $candidate->votes_count }},
                @empty
                @endforelse
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
            ],
            borderWidth: 1
        }]
    };

    new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Vote Distribution'
                }
            }
        }
    });
</script>
@endpush
