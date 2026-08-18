@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Admin Dashboard</h1>
        <p class="text-muted mb-0">Overview of election activity and voter participation.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('elections.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> New Election
        </a>
    </div>
</div>

<!-- Statistics Row -->
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
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Active Elections</span>
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
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Total Votes Cast</span>
                <h2 class="display-6 fw-bold mt-1 mb-0">{{ $totalVotes }}</h2>
                <i class="bi bi-patch-check-fill stat-icon"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-1 text-primary"></i> Recent Elections</h6>
                <a href="{{ route('elections.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentElections as $election)
                        <div class="list-group-item p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-semibold">
                                    <a href="{{ route('elections.show', $election) }}" class="text-decoration-none text-dark hover-primary">
                                        {{ $election->title }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $election->start_date->format('M d, Y') }} - {{ $election->end_date->format('M d, Y') }}
                                </small>
                            </div>
                            <span class="badge bg-{{ $election->status === 'active' ? 'success' : ($election->status === 'completed' ? 'info' : 'secondary') }}">
                                {{ ucfirst($election->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                            No elections created yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-trophy me-1 text-warning"></i> Top Candidates</h6>
                <a href="{{ route('reports.analytics') }}" class="btn btn-sm btn-outline-secondary">Analytics</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topCandidates as $candidate)
                        <div class="list-group-item p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2 rounded-circle bg-light border text-primary fw-bold" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    {{ substr($candidate->name, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ $candidate->name }}</h6>
                                    <small class="text-muted">{{ $candidate->election?->title ?? 'Election' }}</small>
                                </div>
                            </div>
                            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">
                                {{ $candidate->votes_count }} {{ Str::plural('vote', $candidate->votes_count) }}
                            </span>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-people fs-2 d-block mb-1"></i>
                            No votes cast yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
