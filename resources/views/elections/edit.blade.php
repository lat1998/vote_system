@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4">Edit Election</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('elections.update', $election) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Election Title</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $election->title) }}" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $election->description) }}</textarea>
                        @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input id="start_date" type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $election->start_date->format('Y-m-d\TH:i')) }}" required>
                                @error('start_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input id="end_date" type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $election->end_date->format('Y-m-d\TH:i')) }}" required>
                                @error('end_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="draft" {{ old('status', $election->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status', $election->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ old('status', $election->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Election</button>
                        <a href="{{ route('elections.show', $election) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
