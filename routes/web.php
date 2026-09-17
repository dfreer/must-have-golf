<?php

use App\Enums\SocialiteProvidersEnum;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\SocialAccountController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::prefix('auth')->name('auth.')->middleware('guest')->group(function (): void {
    Route::get('login', [OtpController::class, 'showLogin'])->name('login');
    Route::post('otp/request', [OtpController::class, 'requestOtp'])->name('otp.request');
    Route::get('otp', [OtpController::class, 'showOtp'])->name('otp.show');
    Route::post('otp/verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');
    Route::get('social/{provider}', [SocialAccountController::class, 'show'])
        ->name('social.redirect')
        ->whereIn('provider', array_column(SocialiteProvidersEnum::cases(), 'value'));
    Route::match(['get', 'post'], 'social/{provider}/callback', [SocialAccountController::class, 'store'])
        ->name('social.callback')
        ->whereIn('provider', array_column(SocialiteProvidersEnum::cases(), 'value'));
});

Route::post('auth/logout', [OtpController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');
