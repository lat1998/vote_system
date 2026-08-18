@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 fw-bold mb-1">Elections Management</h1>
        <p class="text-muted mb-0">Configure, schedule, and oversee all democratic ballots.</p>
    </div>
    <a href="{{ route('elections.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Create Election
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>Election Title</th>
                    <th>Status</th>
                    <th>Voting Period</th>
                    <th>Candidates</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($elections as $election)
                    <tr>
                        <td>
                            <strong class="text-dark">{{ $election->title }}</strong>
                            @if($election->description)
                                <div class="text-muted small text-truncate" style="max-width: 250px;">{{ $election->description }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $election->status === 'active' ? 'success' : ($election->status === 'completed' ? 'info' : 'secondary') }}">
                                {{ ucfirst($election->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="small">
                                <span class="text-dark fw-semibold">{{ $election->start_date->format('M d, Y') }}</span>
                                <span class="text-muted">to</span>
                                <span class="text-dark fw-semibold">{{ $election->end_date->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $election->candidates_count ?? $election->candidates()->count() }}</span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('elections.show', $election) }}" class="btn btn-outline-primary" title="View Details">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('elections.edit', $election) }}" class="btn btn-outline-secondary" title="Edit Election">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('elections.destroy', $election) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete Election" onclick="return confirm('Are you sure you want to delete this election?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            No elections found. Click "Create Election" to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $elections->links() }}
</div>
@endsection
