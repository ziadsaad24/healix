<?php

use App\Http\Controllers\Api\Auth\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('patient')->group(function () {
    // Public routes
    Route::post('/register', [PatientController::class, 'register']);
    Route::post('/login', [PatientController::class, 'login']);
    
    // Email verification routes
    Route::get('/email/verify/{id}/{hash}', [PatientController::class, 'verify'])
        ->middleware(['signed'])
        ->name('patient.verification.verify');
    
    // Password reset routes
    Route::post('/forgot-password', [PatientController::class, 'forgotPassword']);
    Route::post('/reset-password', [PatientController::class, 'resetPassword']);
    
    // Resend verification email (public route)
    Route::post('/email/resend', [PatientController::class, 'resendVerification']);

    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // Routes that require verified email
        Route::middleware('verified')->group(function () {
            Route::get('/profile', [PatientController::class, 'profile']);
            Route::post('/logout', [PatientController::class, 'logout']);
        });
    });
});