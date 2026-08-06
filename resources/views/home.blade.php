@extends('layout')

@section('content')
<div class="row align-items-center py-5">
    <div class="col-lg-6">
        <h1 class="display-4 fw-bold mb-4">Welcome to the Voting System</h1>
        <p class="lead mb-4">A secure, easy-to-use online voting platform for democratic elections.</p>

        @auth
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-speedometer2 me-1"></i> Go to Dashboard
                </a>
            </div>
        @else
            <div class="mb-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-person-plus me-1"></i> Register
                </a>
            </div>
            <p class="text-muted small">
                <i class="bi bi-shield-check me-1"></i>
                You must log in to access the dashboard and cast votes.
            </p>
        @endauth

        <div class="mt-5">
            <h3 class="fw-bold">Key Features</h3>
            <ul class="list-unstyled mt-3">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Secure voter authentication with login required</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Real-time vote counting and live results</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Admin election and candidate management</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Comprehensive voting analytics</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> RESTful API with token authentication</li>
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Export reports (CSV, JSON, HTML)</li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6 text-center">
        <div class="hero-emoji">🗳️</div>
        <p class="fs-4 text-muted fw-bold">Voting System</p>
    </div>
</div>

<section id="contributors" class="py-5 mt-4 border-top">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Development Team</h2>
        <p class="text-muted">The contributors who built this voting platform</p>
    </div>
    <div class="row g-4 justify-content-center">
        @foreach ($contributors as $member)
            <div class="col-sm-6 col-md-3">
                <div class="card h-100 shadow-sm border-0 contributor-card text-center">
                    <div class="card-body p-4">
                        <div class="contributor-avatar mx-auto mb-3">
                            {{ strtoupper(substr($member['name'], 0, 1)) }}{{ strtoupper(substr(strrchr($member['name'], ' ') ?: $member['name'], 1, 1)) }}
                        </div>
                        <h6 class="fw-bold mb-1">
                            @if (! empty($member['github']))
                                <a href="https://github.com/{{ $member['github'] }}" target="_blank" rel="noopener" class="text-decoration-none">
                                    {{ $member['name'] }}
                                </a>
                            @else
                                {{ $member['name'] }}
                            @endif
                        </h6>
                        <p class="text-muted small mb-0">{{ $member['role'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection

@push('styles')
<style>
    .hero-emoji { font-size: 10rem; line-height: 1; }
    .contributor-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #2563eb;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
    }
    .contributor-card { transition: transform 0.2s ease; }
    .contributor-card:hover { transform: translateY(-4px); }
</style>
@endpush
