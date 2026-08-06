@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-success receipt-card">
            <div class="card-body text-center">
                <h1 class="h3 mb-3 text-success">Vote Recorded Successfully</h1>
                <p class="text-muted">Your vote has been submitted securely.</p>

                <div class="alert alert-info text-start receipt-box">
                    <p class="mb-2"><strong>Election:</strong> {{ $election->title }}</p>
                    <p class="mb-2"><strong>Candidate:</strong> {{ $vote->candidate?->name ?? 'Unknown candidate' }}</p>
                    <p class="mb-2"><strong>Position:</strong> {{ $vote->candidate?->position ?? 'Unassigned' }}</p>
                    <p class="mb-0"><strong>Verification Code:</strong> <code>{{ $vote->qr_token }}</code></p>
                </div>

                <div class="d-flex justify-content-center gap-2 mt-4 no-print">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                    <a href="{{ route('votes.results', $election) }}" class="btn btn-outline-secondary">View Results</a>
                    <button type="button" class="btn btn-outline-success" onclick="window.print()">Print Receipt</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .receipt-card {
        border-width: 2px;
    }

    .receipt-box {
        border-left: 4px solid #198754;
    }

    @media print {
        body {
            background: white !important;
        }

        .no-print {
            display: none !important;
        }

        .receipt-card {
            box-shadow: none !important;
            border: 1px solid #dee2e6;
        }
    }
</style>
@endpush
