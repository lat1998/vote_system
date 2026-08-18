@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 fw-bold mb-1">Reports & Exports</h1>
        <p class="text-muted mb-0">Official audit reports, data exports, and standings for <strong>{{ $election->title }}</strong>.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card stat-card-blue p-3 shadow-sm">
            <div class="card-body p-2">
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Total Votes</span>
                <h2 class="display-6 fw-bold mt-1 mb-0">{{ $totalVotes }}</h2>
                <i class="bi bi-patch-check-fill stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card stat-card-green p-3 shadow-sm">
            <div class="card-body p-2">
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Candidates</span>
                <h2 class="display-6 fw-bold mt-1 mb-0">{{ $results->count() }}</h2>
                <i class="bi bi-people-fill stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card stat-card-teal p-3 shadow-sm">
            <div class="card-body p-2">
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Leading</span>
                <h4 class="fw-bold mt-2 mb-0 text-truncate text-white">{{ $results->count() > 0 ? $results->first()->name : 'N/A' }}</h4>
                <i class="bi bi-trophy stat-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card stat-card-amber p-3 shadow-sm">
            <div class="card-body p-2">
                <span class="text-white text-opacity-75 small text-uppercase fw-semibold">Status</span>
                <h4 class="fw-bold mt-2 mb-0 text-capitalize text-white">{{ $election->status }}</h4>
                <i class="bi bi-info-circle-fill stat-icon"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-bold"><i class="bi bi-download text-primary me-1"></i> Available Export Formats</h6>
    </div>
    <div class="card-body p-4">
        <div class="row g-4 align-items-center">
            <div class="col-md-6">
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('reports.export-csv', $election) }}" class="btn btn-outline-primary py-2 text-start d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark-spreadsheet me-2 fs-5"></i> Export CSV Spreadsheet</span>
                        <i class="bi bi-arrow-down-circle"></i>
                    </a>
                    <a href="{{ route('reports.export-json', $election) }}" class="btn btn-outline-secondary py-2 text-start d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-filetype-json me-2 fs-5"></i> Export Structured JSON</span>
                        <i class="bi bi-arrow-down-circle"></i>
                    </a>
                    <a href="{{ route('reports.view-html', $election) }}" class="btn btn-outline-success py-2 text-start d-flex justify-content-between align-items-center" target="_blank">
                        <span><i class="bi bi-printer me-2 fs-5"></i> Printable HTML Report / PDF</span>
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 rounded-3 bg-light border">
                    <h6 class="fw-bold mb-2 small text-dark"><i class="bi bi-shield-check text-success me-1"></i> Audit Compliance Note</h6>
                    <p class="text-muted small mb-0">
                        Export files contain verifiable tallies, candidate percentages, and cryptographic timestamp data for administrative and electoral audit reporting.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0 fw-bold"><i class="bi bi-table text-primary me-1"></i> Results Breakdown</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">Rank</th>
                    <th>Candidate</th>
                    <th style="width: 120px;">Votes</th>
                    <th style="min-width: 200px;">Share</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $idx => $candidate)
                    <tr class="{{ $idx === 0 && $candidate->votes_count > 0 ? 'table-success bg-opacity-25' : '' }}">
                        <td>
                            @if($idx === 0 && $candidate->votes_count > 0)
                                <span class="badge bg-warning text-dark"><i class="bi bi-award-fill"></i> #1</span>
                            @else
                                <span class="badge bg-light text-secondary border">#{{ $idx + 1 }}</span>
                            @endif
                        </td>
                        <td><strong class="text-dark">{{ $candidate->name }}</strong></td>
                        <td><span class="badge bg-primary fs-6">{{ $candidate->votes_count ?? 0 }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 12px; border-radius: 6px; background-color: #f1f5f9;">
                                    <div class="progress-bar {{ $idx === 0 ? 'bg-success' : 'bg-primary' }}" style="width: {{ $candidate->getVotePercentage() }}%"></div>
                                </div>
                                <span class="small fw-semibold text-dark" style="min-width: 45px;">{{ number_format($candidate->getVotePercentage(), 1) }}%</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No votes cast yet in this election.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 pt-2">
    <a href="{{ route('elections.show', $election) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Election Details
    </a>
</div>
@endsection
