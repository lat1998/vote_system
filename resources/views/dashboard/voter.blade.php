@extends('layout')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1">Voter Dashboard</h1>
            <p class="text-muted mb-0">Welcome back, <strong>{{ auth()->user()->name }}</strong>. Browse active elections and cast your vote.</p>
        </div>
        <div>
            <span class="badge bg-light text-secondary border px-3 py-2">
                <i class="bi bi-person-badge me-1"></i> Voter ID: <strong class="text-dark">{{ auth()->user()->voter_id ?? 'VOTER_'.auth()->id() }}</strong>
            </span>
        </div>
    </div>
</div>

<!-- Available Elections Section -->
<div class="mb-5">
    <div class="d-flex align-items-center gap-2 mb-3">
        <h4 class="h5 fw-bold mb-0">Active Elections Available to Vote</h4>
        <span class="badge bg-primary rounded-pill">{{ $availableElections->count() }}</span>
    </div>

    @if($availableElections->count() > 0)
        <div class="row g-3">
            @foreach($availableElections as $election)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm hover-lift border">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0">{{ $election->title }}</h5>
                                    <span class="badge bg-success"><i class="bi bi-broadcast me-1"></i>Active</span>
                                </div>
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($election->description ?? 'No description provided.', 120) }}
                                </p>
                            </div>
                            <div>
                                <div class="p-2 rounded-3 bg-light border mb-3 small text-muted">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-clock me-1"></i>Ends:</span>
                                        <strong class="text-dark">{{ $election->end_date->format('M d, Y H:i') }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span><i class="bi bi-people me-1"></i>Candidates:</span>
                                        <strong class="text-dark">{{ $election->candidates()->count() }}</strong>
                                    </div>
                                </div>
                                <a href="{{ route('votes.index', $election) }}" class="btn btn-primary w-100">
                                    <i class="bi bi-pencil-square me-1"></i> Cast Vote
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card bg-white border p-4 text-center">
            <div class="text-muted py-3">
                <i class="bi bi-check2-all fs-1 text-primary d-block mb-2"></i>
                <h6 class="fw-bold mb-1">All Caught Up!</h6>
                <p class="text-muted small mb-0">There are no new active elections awaiting your vote at the moment.</p>
            </div>
        </div>
    @endif
</div>

<!-- Voted Elections Section -->
@if($votedElections->count() > 0)
    <div class="mb-5">
        <div class="d-flex align-items-center gap-2 mb-3">
            <h4 class="h5 fw-bold mb-0">Elections You've Voted In</h4>
            <span class="badge bg-success rounded-pill">{{ $votedElections->count() }}</span>
        </div>
        <div class="row g-3">
            @foreach($votedElections as $election)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border border-success border-opacity-25 bg-white">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold mb-0">{{ $election->title }}</h5>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20">
                                        <i class="bi bi-check2-circle me-1"></i>Voted
                                    </span>
                                </div>
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($election->description ?? 'No description provided.', 100) }}
                                </p>
                            </div>
                            <div>
                                <div class="p-2 rounded-3 bg-light border mb-3 small text-muted">
                                    <div class="d-flex justify-content-between">
                                        <span><i class="bi bi-info-circle me-1"></i>Status:</span>
                                        <strong class="text-capitalize text-dark">{{ $election->status }}</strong>
                                    </div>
                                </div>
                                <a href="{{ route('votes.results', $election) }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-bar-chart-fill me-1"></i> View Results
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Completed Elections Section -->
@if($completedElections->count() > 0)
    <div class="mb-5">
        <div class="d-flex align-items-center gap-2 mb-3">
            <h4 class="h5 fw-bold mb-0">Other Completed Elections</h4>
            <span class="badge bg-secondary rounded-pill">{{ $completedElections->count() }}</span>
        </div>
        <div class="row g-3">
            @foreach($completedElections as $election)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border bg-white">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold mb-0">{{ $election->title }}</h5>
                                    <span class="badge bg-secondary">Completed</span>
                                </div>
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($election->description ?? 'No description provided.', 100) }}
                                </p>
                            </div>
                            <div>
                                <div class="p-2 rounded-3 bg-light border mb-3 small text-muted">
                                    <div class="d-flex justify-content-between">
                                        <span><i class="bi bi-calendar-check me-1"></i>Ended:</span>
                                        <strong class="text-dark">{{ $election->end_date->format('M d, Y') }}</strong>
                                    </div>
                                </div>
                                <a href="{{ route('votes.results', $election) }}" class="btn btn-outline-secondary w-100">
                                    <i class="bi bi-pie-chart me-1"></i> View Final Results
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
