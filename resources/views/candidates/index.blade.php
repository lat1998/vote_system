@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Candidates for {{ $election->title }}</h1>
    <a href="{{ route('elections.candidates.create', $election) }}" class="btn btn-success">Add Candidate</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Ballot Position</th>
                    <th>Votes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidates as $candidate)
                    <tr>
                        <td><strong>{{ $candidate->name }}</strong></td>
                        <td>{{ $candidate->position ?: 'Unassigned' }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $candidate->votes_count ?? 0 }}</span>
                        </td>
                        <td>
                            <a href="{{ route('elections.candidates.show', [$election, $candidate]) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('elections.candidates.edit', [$election, $candidate]) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('elections.candidates.destroy', [$election, $candidate]) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No candidates found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $candidates->links() }}
</div>

<div class="mt-4">
    <a href="{{ route('elections.show', $election) }}" class="btn btn-secondary">Back to Election</a>
</div>
@endsection
