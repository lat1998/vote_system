@extends('layout')

@section('content')
<h1 class="mb-4">Vote in {{ $election->title }}</h1>

@if($hasVoted)
    <div class="alert alert-warning" role="alert">
        You have already voted in this election. 
        <a href="{{ route('votes.results', $election) }}" class="alert-link">View results</a>
    </div>
@else
    @if(!$election->isActive())
        <div class="alert alert-danger" role="alert">
            This election is not currently active.
        </div>
    @else
        <div class="alert alert-info" role="alert">
            Select one candidate for each position below.
        </div>

        @forelse($candidatesByPosition as $position => $positionCandidates)
            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                    <h3 class="h5 mb-0">{{ $position }}</h3>
                    <span class="badge bg-secondary">{{ $positionCandidates->count() }} candidate{{ $positionCandidates->count() === 1 ? '' : 's' }}</span>
                </div>

                <div class="row">
                    @foreach($positionCandidates as $candidate)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm voting-card">
                                @if($candidate->image)
                                    <img src="{{ asset('storage/' . $candidate->image) }}" class="card-img-top" alt="{{ $candidate->name }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <span class="text-muted">No Image</span>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $candidate->name }}</h5>
                                    <p class="text-muted small mb-3">Running for {{ $position }}</p>
                                    @if($candidate->bio)
                                        <p class="card-text text-muted">{{ Str::limit($candidate->bio, 100) }}</p>
                                    @endif

                                    <form method="POST" action="{{ route('votes.store', $election) }}" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                        <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Are you sure you want to vote for {{ $candidate->name }} for {{ $position }}?')">
                                            Vote for {{ $position }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No candidates available in this election</p>
            </div>
        @endforelse
    @endif
@endif

<div class="mt-4">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
</div>
@endsection

@push('styles')
<style>
    .voting-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .voting-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>
@endpush
