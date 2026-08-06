<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VoteController;

// Public routes
Route::get('/', function () {
    return view('home', [
        'contributors' => config('contributors.members'),
    ]);
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    // Voter routes - view elections and cast votes
    Route::get('/elections/{election}/vote', [VoteController::class, 'index'])->name('votes.index');
    Route::post('/elections/{election}/vote', [VoteController::class, 'store'])->name('votes.store');
    Route::get('/elections/{election}/vote/confirmation/{vote}', [VoteController::class, 'confirmation'])->name('votes.confirmation');
    Route::get('/elections/{election}/results', [VoteController::class, 'results'])->name('votes.results');

    // Admin routes - manage elections and candidates
    Route::middleware('admin')->group(function () {
        // Reports and exports
        Route::get('/elections/{election}/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/elections/{election}/export-csv', [ReportController::class, 'exportCSV'])->name('reports.export-csv');
        Route::get('/elections/{election}/export-json', [ReportController::class, 'exportJSON'])->name('reports.export-json');
        Route::get('/elections/{election}/export-html', [ReportController::class, 'viewHTML'])->name('reports.view-html');

        Route::resource('elections', ElectionController::class);
        Route::post('/elections/{election}/activate', [ElectionController::class, 'activate'])->name('elections.activate');
        Route::post('/elections/{election}/complete', [ElectionController::class, 'complete'])->name('elections.complete');

        Route::resource('elections.candidates', CandidateController::class);

        // Admin analytics and reports
        Route::get('/admin/analytics', [ReportController::class, 'adminAnalytics'])->name('reports.analytics');
        Route::get('/admin/export-analytics', [ReportController::class, 'exportAnalyticsCSV'])->name('reports.export-analytics');
    });
});
