<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Enums\SocialiteProvidersEnum;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::prefix('auth')->name('auth.')->middleware('guest')->group(function (): void {
    Route::get('login', [AuthenticationController::class, 'showLogin'])->name('login');
    Route::post('otp/request', [AuthenticationController::class, 'requestOtp'])->name('otp.request');
    Route::get('otp', [AuthenticationController::class, 'showOtp'])->name('otp.show');
    Route::post('otp/verify', [AuthenticationController::class, 'verifyOtp'])->name('otp.verify');
    Route::get('social/{provider}', [AuthenticationController::class, 'redirectToProvider'])
        ->name('social.redirect')
        ->whereIn('provider', array_column(SocialiteProvidersEnum::cases(), 'value'));
    Route::match(['get', 'post'], 'social/{provider}/callback', [AuthenticationController::class, 'handleProviderCallback'])
        ->name('social.callback')
        ->whereIn('provider', array_column(SocialiteProvidersEnum::cases(), 'value'));
});

Route::post('auth/logout', [AuthenticationController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');
