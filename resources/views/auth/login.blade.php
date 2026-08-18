@extends('layout')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border p-2">
            <div class="card-body p-4 p-sm-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex p-3 rounded-circle bg-primary bg-opacity-10 text-primary mb-2">
                        <i class="bi bi-box-arrow-in-right fs-2"></i>
                    </div>
                    <h2 class="h4 fw-bold text-dark mb-1">Welcome Back</h2>
                    <p class="text-muted small mb-0">Sign in to your voting dashboard</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                        </div>
                        @error('email')<span class="invalid-feedback d-block mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                            <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" placeholder="••••••••" required>
                        </div>
                        @error('password')<span class="invalid-feedback d-block mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-muted small" for="remember">
                            Remember my login on this device
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </button>
                </form>

                <hr class="my-4 text-muted opacity-25">

                <p class="text-center text-muted small mb-0">
                    Don't have an account yet? <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
