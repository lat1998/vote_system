@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 fw-bold mb-1">Candidates: {{ $election->title }}</h1>
        <p class="text-muted mb-0">Manage registered candidates and ballot positions for this election.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('elections.candidates.create', $election) }}" class="btn btn-success">
            <i class="bi bi-person-plus-fill me-1"></i> Add Candidate
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Position</th>
                    <th>Total Votes</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidates as $candidate)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2 rounded-circle bg-light border text-primary fw-bold" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                    {{ strtoupper(substr($candidate->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong class="text-dark">{{ $candidate->name }}</strong>
                                    @if($candidate->bio)
                                        <div class="text-muted small text-truncate" style="max-width: 250px;">{{ $candidate->bio }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $candidate->position ?: 'Unassigned' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-primary fs-6">{{ $candidate->votes_count ?? 0 }}</span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('elections.candidates.show', [$election, $candidate]) }}" class="btn btn-outline-primary" title="View Profile">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('elections.candidates.edit', [$election, $candidate]) }}" class="btn btn-outline-secondary" title="Edit Profile">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('elections.candidates.destroy', [$election, $candidate]) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Remove Candidate" onclick="return confirm('Are you sure you want to remove this candidate?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="bi bi-person-x fs-2 d-block mb-2"></i>
                            No candidates enrolled yet. Click "Add Candidate" to register someone.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $candidates->links() }}
</div>

<div class="mt-4 pt-2">
    <a href="{{ route('elections.show', $election) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Election Details
    </a>
</div>
@endsection
