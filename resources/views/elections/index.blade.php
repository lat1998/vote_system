@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Elections</h1>
    <a href="{{ route('elections.create') }}" class="btn btn-success">Create Election</a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Candidates</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($elections as $election)
                    <tr>
                        <td>
                            <strong>{{ $election->title }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-{{ $election->status === 'active' ? 'success' : ($election->status === 'completed' ? 'info' : 'secondary') }}">
                                {{ ucfirst($election->status) }}
                            </span>
                        </td>
                        <td>{{ $election->start_date->format('M d, Y H:i') }}</td>
                        <td>{{ $election->end_date->format('M d, Y H:i') }}</td>
                        <td>{{ $election->candidates()->count() }}</td>
                        <td>
                            <a href="{{ route('elections.show', $election) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('elections.edit', $election) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('elections.destroy', $election) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No elections found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $elections->links() }}
</div>
@endsection
