@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1">My Profile</h1>
                        <p class="text-muted mb-0">Manage your account details and account type.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100">
                            <h5 class="mb-3">Account Information</h5>
                            <p class="mb-2"><strong>Name:</strong> {{ $user->name }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="mb-2"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                            <p class="mb-0"><strong>Voter ID:</strong> {{ $user->voter_id ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded p-3 h-100 text-center">
                            <h5 class="mb-3">User QR Code</h5>
                            <div class="d-flex justify-content-center mb-3">
                                <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR code for user {{ $user->id }}" class="img-fluid" style="max-width: 220px;">
                            </div>
                            <p class="text-muted mb-0">User ID: {{ $user->id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
