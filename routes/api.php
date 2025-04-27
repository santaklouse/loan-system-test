<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

// Clients
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients/show/{id}', [ClientController::class, 'show']);

// Loans
Route::post('/loans/check', [LoanController::class, 'check']);
Route::post('/loans/issue', [LoanController::class, 'issue']);
Route::get('/loans/show/{id}', [LoanController::class, 'show']);
