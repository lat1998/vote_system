@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="mb-4">Add Candidate to {{ $election->title }}</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('elections.candidates.store', $election) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Candidate Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Biography</label>
                        <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="4">{{ old('bio') }}</textarea>
                        @error('bio')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Ballot Position</label>
                        <select id="position" class="form-select @error('position') is-invalid @enderror" name="position" required>
                            <option value="">Select a position</option>
                            <option value="President" {{ old('position') == 'President' ? 'selected' : '' }}>President</option>
                            <option value="Vice President" {{ old('position') == 'Vice President' ? 'selected' : '' }}>Vice President</option>
                            <option value="Senator" {{ old('position') == 'Senator' ? 'selected' : '' }}>Senator</option>
                            <option value="Councilor" {{ old('position') == 'Councilor' ? 'selected' : '' }}>Councilor</option>
                            <option value="Mayor" {{ old('position') == 'Mayor' ? 'selected' : '' }}>Mayor</option>
                        </select>
                        @error('position')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Add Candidate</button>
                        <a href="{{ route('elections.candidates.index', $election) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
