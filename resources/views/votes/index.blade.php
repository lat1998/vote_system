@extends('layout')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
        <h1 class="h3 fw-bold mb-0">Vote: {{ $election->title }}</h1>
        <span class="badge bg-success px-3 py-2 fs-6">
            <i class="bi bi-broadcast me-1"></i> Active Ballot
        </span>
    </div>
    @if($election->description)
        <p class="text-muted mb-0">{{ $election->description }}</p>
    @endif
</div>

@if($hasVoted)
    <div class="card border-warning bg-warning bg-opacity-10 p-4 text-center my-4">
        <div class="py-3">
            <i class="bi bi-check-circle-fill text-warning fs-1 d-block mb-2"></i>
            <h4 class="fw-bold mb-2">You Have Already Voted in This Election</h4>
            <p class="text-muted mb-4">Your ballot has been securely counted. You can view the live progress and final tallies anytime.</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('votes.results', $election) }}" class="btn btn-primary">
                    <i class="bi bi-bar-chart-fill me-1"></i> View Live Results
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
@else
    @if(!$election->isActive())
        <div class="alert alert-danger d-flex align-items-center gap-2 p-3" role="alert">
            <i class="bi bi-exclamation-octagon-fill fs-4"></i>
            <div>
                <strong>Election Inactive:</strong> This election is not currently accepting votes.
            </div>
        </div>
    @else
        <div class="alert alert-info d-flex align-items-center gap-2 p-3 mb-4 shadow-sm" role="alert">
            <i class="bi bi-info-circle-fill fs-5"></i>
            <div>
                Choose your preferred candidate for each position below. Confirm your selection to submit your ballot.
            </div>
        </div>

        @forelse($candidatesByPosition as $position => $positionCandidates)
            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
                    <h4 class="h5 fw-bold text-dark mb-0">
                        <i class="bi bi-award text-primary me-1"></i> {{ $position }}
                    </h4>
                    <span class="badge bg-light text-secondary border">
                        {{ $positionCandidates->count() }} candidate{{ $positionCandidates->count() === 1 ? '' : 's' }}
                    </span>
                </div>

                <div class="row g-4">
                    @foreach($positionCandidates as $candidate)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm voting-card border overflow-hidden">
                                @if($candidate->image)
                                    <img src="{{ asset('storage/' . $candidate->image) }}" class="card-img-top" alt="{{ $candidate->name }}" style="height: 180px; object-fit: cover;">
                                @else
                                    <div class="candidate-avatar-header py-4 text-center">
                                        <div class="candidate-initials-circle mx-auto mb-1">
                                            {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                        </div>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <h5 class="card-title fw-bold text-dark mb-1">{{ $candidate->name }}</h5>
                                        <span class="badge bg-primary bg-opacity-10 text-primary mb-3">
                                            {{ $position }}
                                        </span>
                                        @if($candidate->bio)
                                            <p class="card-text text-muted small mb-3">
                                                {{ Str::limit($candidate->bio, 110) }}
                                            </p>
                                        @endif
                                    </div>

                                    <form method="POST" action="{{ route('votes.store', $election) }}" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                        <button type="submit" class="btn btn-primary w-100 py-2" onclick="return confirm('Are you sure you want to vote for {{ $candidate->name }} for {{ $position }}?')">
                                            <i class="bi bi-check2-circle me-1"></i> Vote for {{ $candidate->name }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="card border p-5 text-center my-4 bg-white">
                <div class="text-muted">
                    <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                    <h6 class="fw-bold mb-1">No Candidates Found</h6>
                    <p class="small mb-0">No candidates have been registered for this election yet.</p>
                </div>
            </div>
        @endforelse
    @endif
@endif

<div class="mt-4 pt-2">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>
@endsection

@push('styles')
<style>
    .voting-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .voting-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.1) !important;
    }
    .candidate-avatar-header {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border-bottom: 1px solid #e2e8f0;
    }
    .candidate-initials-circle {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }
</style>
@endpush
