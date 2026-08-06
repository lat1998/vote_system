<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/votes', [ApiController::class, 'castVote']);
});

Route::get('/candidates', [ApiController::class, 'getCandidates']);
Route::get('/candidates/{candidate}', [ApiController::class, 'getCandidate']);

Route::get('/elections', [ApiController::class, 'getElections']);
Route::get('/elections/{election}', [ApiController::class, 'getElection']);
Route::get('/elections/{election}/candidates', [ApiController::class, 'getCandidatesByElection']);
Route::get('/elections/{election}/results', [ApiController::class, 'getElectionResults']);
Route::get('/results/{election}', [ApiController::class, 'getResults']);

Route::middleware(['auth:sanctum', 'admin.api'])->prefix('admin')->group(function () {
    Route::post('/elections', [ApiController::class, 'storeElection']);
    Route::put('/elections/{election}', [ApiController::class, 'updateElection']);
    Route::delete('/elections/{election}', [ApiController::class, 'deleteElection']);

    Route::post('/elections/{election}/candidates', [ApiController::class, 'storeCandidate']);
    Route::put('/candidates/{candidate}', [ApiController::class, 'updateCandidate']);
    Route::delete('/candidates/{candidate}', [ApiController::class, 'deleteCandidate']);
});
