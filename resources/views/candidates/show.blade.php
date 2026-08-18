@extends('layout')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center gy-4">
                    <div class="col-md-5 text-center">
                        @if($candidate->image)
                            <img src="{{ asset('storage/' . $candidate->image) }}" alt="{{ $candidate->name }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 240px; object-fit: cover;">
                        @else
                            <div class="p-4 rounded-4 bg-light border d-flex flex-column align-items-center justify-content-center mx-auto" style="width: 180px; height: 180px;">
                                <div class="p-3 rounded-circle bg-primary text-white fw-bold display-6 mb-1 shadow-sm" style="width: 72px; height: 72px; display: flex; align-items: center; justify-content: center;">
                                    {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                </div>
                                <span class="text-muted small">No photo uploaded</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2">
                            {{ $candidate->position ?: 'Candidate' }}
                        </span>
                        <h2 class="h3 fw-bold text-dark mb-1">{{ $candidate->name }}</h2>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-collection me-1"></i> Running in <a href="{{ route('elections.show', $election) }}" class="text-decoration-none fw-semibold">{{ $election->title }}</a>
                        </p>

                        @if($candidate->bio)
                            <div class="p-3 rounded-3 bg-light border mb-3">
                                <small class="text-muted d-block fw-semibold mb-1">Biography / Statement:</small>
                                <p class="mb-0 text-dark small">{{ $candidate->bio }}</p>
                            </div>
                        @endif

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="p-2 border rounded-3 bg-white text-center">
                                    <small class="text-muted d-block">Votes Received</small>
                                    <strong class="text-primary fs-5">{{ $voteCount }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded-3 bg-white text-center">
                                    <small class="text-muted d-block">Vote Share</small>
                                    <strong class="text-success fs-5">{{ number_format($votePercentage, 1) }}%</strong>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="progress" style="height: 14px; border-radius: 7px; background-color: #e2e8f0;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $votePercentage }}%"></div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('elections.candidates.edit', [$election, $candidate]) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                            <a href="{{ route('elections.candidates.index', $election) }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left me-1"></i> Back to Candidates
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
