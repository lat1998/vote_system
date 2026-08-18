@extends('layout')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border p-2">
            <div class="card-body p-4 p-sm-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex p-3 rounded-circle bg-primary bg-opacity-10 text-primary mb-2">
                        <i class="bi bi-person-plus-fill fs-2"></i>
                    </div>
                    <h2 class="h4 fw-bold text-dark mb-1">Create Voter Account</h2>
                    <p class="text-muted small mb-0">Register to cast your official ballots</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                            <input id="name" type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                        </div>
                        @error('name')<span class="invalid-feedback d-block mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                        </div>
                        @error('email')<span class="invalid-feedback d-block mt-1">{{ $message }}</span>@enderror
                    </div>

                    <input type="hidden" name="role" value="voter">

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                            <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" placeholder="••••••••" required>
                        </div>
                        @error('password')<span class="invalid-feedback d-block mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                            <input id="password_confirmation" type="password" class="form-control border-start-0" name="password_confirmation" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-person-check-fill me-1"></i> Register Account
                    </button>
                </form>

                <hr class="my-4 text-muted opacity-25">

                <p class="text-center text-muted small mb-0">
                    Already have an account? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Sign in here</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
