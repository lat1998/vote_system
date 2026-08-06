@extends('layout')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 class="mb-4">Admin Dashboard</h1>
    </div>
</div>

<!-- Statistics Row -->
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
                <h6 class="card-title">Total Votes Cast</h6>
                <h2 class="mb-0">{{ $totalVotes }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Recent Elections</h5>
            </div>
            <div class="card-body">
                @forelse($recentElections as $election)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-1">
                            <a href="{{ route('elections.show', $election) }}">{{ $election->title }}</a>
                        </h6>
                        <small class="text-muted">
                            <span class="badge bg-{{ $election->status === 'active' ? 'success' : ($election->status === 'completed' ? 'info' : 'secondary') }}">
                                {{ ucfirst($election->status) }}
                            </span>
                        </small>
                    </div>
                @empty
                    <p class="text-muted">No elections yet</p>
                @endforelse
                <a href="{{ route('elections.index') }}" class="btn btn-sm btn-primary">View All Elections</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Top Candidates</h5>
            </div>
            <div class="card-body">
                @forelse($topCandidates as $candidate)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="mb-1">{{ $candidate->name }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $candidate->election->title }}</small>
                            <span class="badge bg-primary">{{ $candidate->votes_count }} votes</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No votes yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <a href="{{ route('elections.create') }}" class="btn btn-success">
            Create New Election
        </a>
    </div>
</div>
@endsection
