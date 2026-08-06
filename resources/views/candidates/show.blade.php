@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        @if($candidate->image)
                            <img src="{{ asset('storage/' . $candidate->image) }}" alt="{{ $candidate->name }}" class="img-fluid rounded" style="max-height: 300px;">
                        @else
                            <div class="bg-light rounded" style="height: 300px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">No Image</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h2 class="mb-3">{{ $candidate->name }}</h2>

                        <div class="mb-3">
                            <strong>Election:</strong>
                            <a href="{{ route('elections.show', $election) }}">{{ $election->title }}</a>
                        </div>

                        @if($candidate->bio)
                            <div class="mb-3">
                                <strong>Biography:</strong>
                                <p>{{ $candidate->bio }}</p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <strong>Votes Received:</strong>
                            <span class="badge bg-primary fs-6">{{ $voteCount }}</span>
                        </div>

                        <div class="mb-3">
                            <strong>Vote Percentage:</strong>
                            <span class="badge bg-success fs-6">{{ number_format($votePercentage, 2) }}%</span>
                        </div>

                        <div class="mb-3">
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" style="width: {{ $votePercentage }}%">
                                    {{ number_format($votePercentage, 1) }}%
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('elections.candidates.edit', [$election, $candidate]) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('elections.candidates.index', $election) }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
