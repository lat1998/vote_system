@extends('layout')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $election->title }}</h1>
        <span class="badge bg-{{ $election->status === 'active' ? 'success' : ($election->status === 'completed' ? 'info' : 'secondary') }} fs-6">
            {{ ucfirst($election->status) }}
        </span>
    </div>

    @if($election->description)
        <p class="text-muted">{{ $election->description }}</p>
    @endif

    <div class="row mb-3">
        <div class="col-md-6">
            <small><strong>Start Date:</strong> {{ $election->start_date->format('M d, Y H:i') }}</small><br>
            <small><strong>End Date:</strong> {{ $election->end_date->format('M d, Y H:i') }}</small>
        </div>
        <div class="col-md-6">
            <small><strong>Election Code:</strong> {{ $election->election_code }}</small><br>
            <small><strong>Total Votes:</strong> {{ $totalVotes }}</small>
        </div>
    </div>

    @auth
        @if(auth()->user()->isAdmin())
            <div class="mb-3">
                <a href="{{ route('elections.edit', $election) }}" class="btn btn-warning btn-sm">Edit</a>
                @if($election->status === 'draft')
                    <form method="POST" action="{{ route('elections.activate', $election) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Activate</button>
                    </form>
                @elseif($election->status === 'active')
                    <form method="POST" action="{{ route('elections.complete', $election) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-info btn-sm">Mark Complete</button>
                    </form>
                @endif
                <a href="{{ route('elections.candidates.index', $election) }}" class="btn btn-primary btn-sm">Manage Candidates</a>
            </div>
        @endif
    @endauth
</div>

<h3 class="mb-3">Candidates & Results</h3>

<div class="row">
    @forelse($candidates as $candidate)
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $candidate->name }}</h5>
                    @if($candidate->bio)
                        <p class="card-text text-muted">{{ $candidate->bio }}</p>
                    @endif
                    
                    <div class="mb-2">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Votes: <strong>{{ $candidate->votes_count ?? 0 }}</strong></span>
                            <span>{{ number_format($candidate->getVotePercentage(), 2) }}%</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: {{ $candidate->getVotePercentage() }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-muted">No candidates added yet</p>
        </div>
    @endforelse
</div>
@endsection
