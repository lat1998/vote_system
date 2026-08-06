@extends('layout')

@section('content')
<div class="mb-4">
    <h1>Reports & Exports</h1>
    <h4 class="text-muted">{{ $election->title }}</h4>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="card-title">{{ $totalVotes }}</h3>
                <p class="card-text text-muted">Total Votes Cast</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="card-title">{{ $results->count() }}</h3>
                <p class="card-text text-muted">Candidates</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">
                    @if($results->count() > 0)
                        {{ $results->first()->name }}
                    @else
                        N/A
                    @endif
                </h5>
                <p class="card-text text-muted">Leading Candidate</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <span class="badge bg-{{ $election->status === 'active' ? 'success' : 'secondary' }} fs-5">{{ ucfirst($election->status) }}</span>
                <p class="card-text text-muted mt-2">Election Status</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Download Reports</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <h6>Export Formats</h6>
                <a href="{{ route('reports.export-csv', $election) }}" class="btn btn-primary btn-sm mb-2 w-100">
                    📊 Export as CSV
                </a>
                <a href="{{ route('reports.export-json', $election) }}" class="btn btn-info btn-sm mb-2 w-100">
                    📋 Export as JSON
                </a>
                <a href="{{ route('reports.view-html', $election) }}" class="btn btn-warning btn-sm mb-2 w-100" target="_blank">
                    🖨️ View as HTML (Print/PDF)
                </a>
            </div>
            <div class="col-md-6 mb-3">
                <h6>Report Information</h6>
                <div class="alert alert-info" role="alert">
                    <small>
                        <strong>CSV Format:</strong> Spreadsheet compatible<br>
                        <strong>JSON Format:</strong> API friendly, structured data<br>
                        <strong>HTML Format:</strong> Printable and PDF-convertible
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">Results Summary</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Rank</th>
                    <th>Candidate</th>
                    <th>Votes</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $idx => $candidate)
                    <tr>
                        <td><strong>#{{ $idx + 1 }}</strong></td>
                        <td>{{ $candidate->name }}</td>
                        <td><span class="badge bg-primary">{{ $candidate->votes_count ?? 0 }}</span></td>
                        <td>
                            <div class="progress" style="min-width: 50px;">
                                <div class="progress-bar" style="width: {{ $candidate->getVotePercentage() }}%">
                                    {{ number_format($candidate->getVotePercentage(), 1) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No votes cast yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('elections.show', $election) }}" class="btn btn-secondary">Back to Election</a>
</div>
@endsection
