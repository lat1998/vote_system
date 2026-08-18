@extends('layout')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
        <h1 class="h3 fw-bold mb-0">{{ $election->title }}</h1>
        <span class="badge bg-{{ $election->status === 'active' ? 'success' : ($election->status === 'completed' ? 'info' : 'secondary') }} px-3 py-2 fs-6">
            {{ ucfirst($election->status) }}
        </span>
    </div>

    @if($election->description)
        <p class="text-muted mb-3">{{ $election->description }}</p>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-md-3">
            <div class="p-3 bg-light rounded-3 border">
                <small class="text-muted d-block">Election Code</small>
                <code class="text-dark fw-bold">{{ $election->election_code }}</code>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="p-3 bg-light rounded-3 border">
                <small class="text-muted d-block">Total Votes Cast</small>
                <strong class="text-primary fs-5">{{ $totalVotes }}</strong>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="p-3 bg-light rounded-3 border">
                <small class="text-muted d-block">Start Date</small>
                <span class="small fw-semibold text-dark">{{ $election->start_date->format('M d, Y H:i') }}</span>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="p-3 bg-light rounded-3 border">
                <small class="text-muted d-block">End Date</small>
                <span class="small fw-semibold text-dark">{{ $election->end_date->format('M d, Y H:i') }}</span>
            </div>
        </div>
    </div>

    @auth
        @if(auth()->user()->isAdmin())
            <div class="card p-3 bg-white border shadow-sm mb-4">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted small fw-semibold me-2"><i class="bi bi-gear-fill me-1"></i> Admin Actions:</span>
                    <a href="{{ route('elections.edit', $election) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil me-1"></i> Edit Election
                    </a>
                    <a href="{{ route('elections.candidates.index', $election) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-people me-1"></i> Manage Candidates
                    </a>
                    <a href="{{ route('reports.index', $election) }}" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-file-earmark-text me-1"></i> Reports & Exports
                    </a>
                    <a href="{{ route('votes.results', $election) }}" class="btn btn-sm btn-outline-info">
                        <i class="bi bi-bar-chart-fill me-1"></i> Public Results
                    </a>

                    @if($election->status === 'draft')
                        <form method="POST" action="{{ route('elections.activate', $election) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Activate this election for voting now?')">
                                <i class="bi bi-play-fill me-1"></i> Launch Election
                            </button>
                        </form>
                    @elseif($election->status === 'active')
                        <form method="POST" action="{{ route('elections.complete', $election) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Mark this election as completed and close voting?')">
                                <i class="bi bi-check2-circle me-1"></i> Close & Complete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    @endauth
</div>

<h4 class="h5 fw-bold mb-3"><i class="bi bi-person-lines-fill text-primary me-1"></i> Candidates & Standing</h4>

<div class="row g-3">
    @forelse($candidates as $candidate)
        <div class="col-md-6">
            <div class="card shadow-sm border h-100 p-3">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="card-title fw-bold mb-0 text-dark">{{ $candidate->name }}</h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary small">{{ $candidate->position }}</span>
                        </div>
                        <span class="badge bg-primary fs-6">{{ $candidate->votes_count ?? 0 }} {{ Str::plural('vote', $candidate->votes_count ?? 0) }}</span>
                    </div>

                    @if($candidate->bio)
                        <p class="card-text text-muted small mb-3">{{ Str::limit($candidate->bio, 120) }}</p>
                    @endif
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between mb-1 small text-muted">
                            <span>Vote Share</span>
                            <strong class="text-dark">{{ number_format($candidate->getVotePercentage(), 1) }}%</strong>
                        </div>
                        <div class="progress" style="height: 12px; border-radius: 6px; background-color: #f1f5f9;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $candidate->getVotePercentage() }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border p-4 text-center text-muted bg-white">
                <i class="bi bi-people fs-2 d-block mb-1"></i>
                No candidates enrolled yet in this election.
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4 pt-2">
    <a href="{{ route('elections.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Elections
    </a>
</div>
@endsection
