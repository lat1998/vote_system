@extends('layout')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-7 col-lg-6">
        <div class="card shadow-sm border-0 receipt-card overflow-hidden">
            <div class="bg-success bg-opacity-10 text-center p-4 border-bottom border-success border-opacity-25">
                <div class="d-inline-flex p-3 rounded-circle bg-success text-white shadow-sm mb-3">
                    <i class="bi bi-patch-check-fill fs-1"></i>
                </div>
                <h2 class="h4 fw-bold text-success mb-1">Official Ballot Receipt</h2>
                <p class="text-muted small mb-0">Your vote has been cast and recorded on the ballot ledger.</p>
            </div>

            <div class="card-body p-4">
                <div class="p-3 rounded-3 bg-light border mb-4">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">Election</span>
                        <strong class="text-dark">{{ $election->title }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">Candidate Selected</span>
                        <strong class="text-primary">{{ $vote->candidate?->name ?? 'Candidate' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">Ballot Position</span>
                        <span class="badge bg-secondary">{{ $vote->candidate?->position ?? 'Unassigned' }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted small">Timestamp</span>
                        <span class="small text-dark">{{ $vote->created_at ? $vote->created_at->format('M d, Y H:i:s') : now()->format('M d, Y H:i:s') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <span class="text-muted small">Verification Token</span>
                        <code class="bg-white border px-2 py-1 rounded text-dark fw-bold small">{{ $vote->qr_token }}</code>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2 no-print">
                    <button type="button" class="btn btn-outline-success w-100" onclick="window.print()">
                        <i class="bi bi-printer me-1"></i> Print / Save Receipt
                    </button>
                    <div class="d-flex gap-2">
                        <a href="{{ route('votes.results', $election) }}" class="btn btn-outline-primary flex-fill">
                            <i class="bi bi-bar-chart-fill me-1"></i> View Results
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary flex-fill">
                            <i class="bi bi-grid-fill me-1"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .receipt-card {
        border-radius: 16px;
        border: 1px solid #e2e8f0 !important;
    }
    @media print {
        body {
            background: white !important;
        }
        .navbar-custom, footer, .no-print, .alert {
            display: none !important;
        }
        .receipt-card {
            box-shadow: none !important;
            border: 1px solid #cbd5e1 !important;
        }
    }
</style>
@endpush
