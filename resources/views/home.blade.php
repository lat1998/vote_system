@extends('layout')

@section('content')
<div class="row align-items-center py-5 gy-4">
    <div class="col-lg-7">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-3 rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 fw-semibold small">
            <i class="bi bi-shield-check"></i> Secure & Verifiable Voting Platform
        </div>
        <h1 class="display-5 fw-extrabold mb-3 text-slate-900" style="letter-spacing: -0.03em; font-weight: 800;">
            Transparent Elections,<br><span class="text-primary">Instant Results.</span>
        </h1>
        <p class="lead text-muted mb-4" style="font-size: 1.15rem; line-height: 1.6;">
            A reliable online voting system built for simplicity and integrity. Cast your vote securely, track results in real-time, and download comprehensive election reports.
        </p>

        @auth
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-grid-fill me-1"></i> Go to Dashboard
                </a>
            </div>
        @else
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login to Vote
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-person-plus me-1"></i> Create Account
                </a>
            </div>
            <p class="text-muted small d-flex align-items-center gap-1">
                <i class="bi bi-lock-fill text-secondary"></i>
                Authentication required to participate in elections.
            </p>
        @endauth
    </div>

    <div class="col-lg-5">
        <div class="card shadow-sm border-0 bg-white p-4 text-center position-relative overflow-hidden">
            <div class="p-4 rounded-4 bg-light mb-3">
                <div class="display-1 mb-2">🗳️</div>
                <h4 class="fw-bold mb-1">Live Democratic Ballot</h4>
                <p class="text-muted small mb-0">Cryptographically verifiable vote receipts</p>
            </div>
            <div class="row g-2 text-start">
                <div class="col-6">
                    <div class="p-2 border rounded-3 bg-white">
                        <small class="text-muted d-block">Authentication</small>
                        <strong class="text-success"><i class="bi bi-check2-circle me-1"></i>Sanctum 2FA</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 border rounded-3 bg-white">
                        <small class="text-muted d-block">Tallies</small>
                        <strong class="text-primary"><i class="bi bi-activity me-1"></i>Instant Count</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="py-4 my-3">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100 p-3 hover-lift border">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Voter Security</h6>
                </div>
                <p class="text-muted small mb-0">Single-vote enforcement per election with encrypted QR verification tokens.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-3 hover-lift border">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success">
                        <i class="bi bi-pie-chart-fill fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Live Analytics</h6>
                </div>
                <p class="text-muted small mb-0">Real-time candidate rankings, vote percentages, and interactive Chart.js graphs.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 p-3 hover-lift border">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="p-2 rounded-3 bg-info bg-opacity-10 text-info">
                        <i class="bi bi-file-earmark-arrow-down-fill fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-0">Flexible Exports</h6>
                </div>
                <p class="text-muted small mb-0">Export official audit-ready election reports in CSV, JSON, and print-ready HTML formats.</p>
            </div>
        </div>
    </div>
</div>

<!-- Contributors Section -->
<section id="contributors" class="py-5 mt-4 border-top">
    <div class="text-center mb-4">
        <h3 class="fw-bold mb-1">Development Team</h3>
        <p class="text-muted">The contributors who built and maintain this platform</p>
    </div>
    <div class="row g-3 justify-content-center">
        @foreach ($contributors as $member)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border contributor-card text-center p-3">
                    <div class="card-body p-2">
                        <div class="contributor-avatar mx-auto mb-3 shadow-sm">
                            {{ strtoupper(substr($member['name'], 0, 1)) }}{{ strtoupper(substr(strrchr($member['name'], ' ') ?: $member['name'], 1, 1)) }}
                        </div>
                        <h6 class="fw-bold mb-1">
                            @if (! empty($member['github']))
                                <a href="https://github.com/{{ $member['github'] }}" target="_blank" rel="noopener" class="text-decoration-none text-dark hover-primary">
                                    {{ $member['name'] }} <i class="bi bi-box-arrow-up-right small text-muted"></i>
                                </a>
                            @else
                                {{ $member['name'] }}
                            @endif
                        </h6>
                        <span class="badge bg-light text-secondary border small">{{ $member['role'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection

@push('styles')
<style>
    .contributor-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        font-weight: 700;
        letter-spacing: 0.05em;
    }
    .contributor-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .contributor-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .hover-primary:hover {
        color: #2563eb !important;
    }
</style>
@endpush
