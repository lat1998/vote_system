@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 fw-bold mb-1">System Analytics & Metrics</h1>
        <p class="text-muted mb-0">High-level participation metrics and election breakdown across the system.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('reports.export-analytics') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export Metrics CSV
        </a>
    </div>
</div>

<!-- Key Metrics -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card stat-card-blue p-3 shadow-sm">
            <div class="card-body p-2">
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Total Elections</span>
                <h2 class="display-6 fw-bold mt-1 mb-0">{{ $totalElections }}</h2>
                <i class="bi bi-collection stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card stat-card-green p-3 shadow-sm">
            <div class="card-body p-2">
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Active</span>
                <h2 class="display-6 fw-bold mt-1 mb-0">{{ $activeElections }}</h2>
                <i class="bi bi-broadcast stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card stat-card-teal p-3 shadow-sm">
            <div class="card-body p-2">
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Completed</span>
                <h2 class="display-6 fw-bold mt-1 mb-0">{{ $completedElections }}</h2>
                <i class="bi bi-check2-circle stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card stat-card-amber p-3 shadow-sm">
            <div class="card-body p-2">
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Draft / Pending</span>
                <h2 class="display-6 fw-bold mt-1 mb-0">{{ $draftElections }}</h2>
                <i class="bi bi-pencil-square stat-icon"></i>
            </div>
        </div>
    </div>
</div>

<!-- Overall Totals -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-fingerprint fs-2"></i>
                </div>
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Total Votes Recorded</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalVotes }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-success bg-opacity-10 text-success">
                    <i class="bi bi-people-fill fs-2"></i>
                </div>
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Total Candidates Enrolled</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalCandidates }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Election Details Table -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-table text-primary me-1"></i> Election-Level Breakdown</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Election Title</th>
                    <th>Status</th>
                    <th>Candidates</th>
                    <th>Total Votes</th>
                    <th>Avg Votes / Candidate</th>
                </tr>
            </thead>
            <tbody>
                @forelse($electionStats as $stat)
                    <tr>
                        <td><strong class="text-dark">{{ $stat['title'] }}</strong></td>
                        <td>
                            <span class="badge bg-{{ $stat['status'] === 'active' ? 'success' : ($stat['status'] === 'completed' ? 'info' : 'secondary') }}">
                                {{ ucfirst($stat['status']) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $stat['candidate_count'] }}</span>
                        </td>
                        <td>
                            <span class="badge bg-primary fs-6">{{ $stat['total_votes'] }}</span>
                        </td>
                        <td>
                            <span class="text-muted fw-semibold">
                                @if($stat['candidate_count'] > 0)
                                    {{ number_format($stat['total_votes'] / $stat['candidate_count'], 1) }}
                                @else
                                    0
                                @endif
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No election statistics found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 pt-2">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>
@endsection
