@extends('layout')

@section('content')
<h1 class="mb-4">Voter Dashboard</h1>

@if($availableElections->count() > 0)
    <div class="mb-5">
        <h3 class="mb-3">Available Elections to Vote</h3>
        <div class="row">
            @foreach($availableElections as $election)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $election->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($election->description, 100) }}</p>
                            <div class="mb-3">
                                <small class="text-muted">
                                    <strong>Ends:</strong> {{ $election->end_date->format('M d, Y H:i') }}
                                </small>
                            </div>
                            <a href="{{ route('votes.index', $election) }}" class="btn btn-primary btn-sm w-100">
                                Cast Vote
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="alert alert-info">
        No active elections available at the moment.
    </div>
@endif

@if($votedElections->count() > 0)
    <div class="mb-5">
        <h3 class="mb-3">Elections You've Voted In</h3>
        <div class="row">
            @foreach($votedElections as $election)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $election->title }}</h5>
                            <p class="card-text text-muted">
                                <span class="badge bg-success">✓ Voted</span>
                            </p>
                            <a href="{{ route('votes.results', $election) }}" class="btn btn-info btn-sm w-100">
                                View Results
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@if($completedElections->count() > 0)
    <div class="mb-5">
        <h3 class="mb-3">Completed Elections</h3>
        <div class="row">
            @foreach($completedElections as $election)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $election->title }}</h5>
                            <p class="card-text text-muted">
                                <span class="badge bg-secondary">Completed</span>
                            </p>
                            <a href="{{ route('votes.results', $election) }}" class="btn btn-secondary btn-sm w-100">
                                View Results
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
