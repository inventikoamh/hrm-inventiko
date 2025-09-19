<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    // Registration disabled

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    // Password Reset Routes
    Route::get('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotPasswordForm'])
        ->name('password.request');
    Route::post('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('reset-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});

// Logout route
Route::post('logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
