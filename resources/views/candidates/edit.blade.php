@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4">Edit Candidate</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('elections.candidates.update', [$candidate->election, $candidate]) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Candidate Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $candidate->name) }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Biography</label>
                        <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="4">{{ old('bio', $candidate->bio) }}</textarea>
                        @error('bio')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Ballot Position</label>
                        <select id="position" class="form-select @error('position') is-invalid @enderror" name="position" required>
                            <option value="">Select a position</option>
                            <option value="President" {{ old('position', $candidate->position) == 'President' ? 'selected' : '' }}>President</option>
                            <option value="Vice President" {{ old('position', $candidate->position) == 'Vice President' ? 'selected' : '' }}>Vice President</option>
                            <option value="Senator" {{ old('position', $candidate->position) == 'Senator' ? 'selected' : '' }}>Senator</option>
                            <option value="Councilor" {{ old('position', $candidate->position) == 'Councilor' ? 'selected' : '' }}>Councilor</option>
                            <option value="Mayor" {{ old('position', $candidate->position) == 'Mayor' ? 'selected' : '' }}>Mayor</option>
                        </select>
                        @error('position')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Candidate</button>
                        <a href="{{ route('elections.candidates.show', [$candidate->election, $candidate]) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
