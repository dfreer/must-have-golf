<?php

use App\Enums\SocialiteProvidersEnum;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\SocialAccountController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Account\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::controller(PageController::class)->group(function (): void {
    Route::get('builder', 'builder')->name('builder');
    Route::get('products', 'products')->name('products');
    Route::get('guides', 'guides')->name('guides');
    Route::get('completed-builds', 'completedBuilds')->name('completed-builds');
    Route::get('about', 'about')->name('about');
    Route::get('affiliate-disclosure', 'affiliateDisclosure')->name('affiliate-disclosure');
    Route::get('contact', 'contact')->name('contact');
    Route::get('privacy-policy', 'privacyPolicy')->name('privacy-policy');
    Route::get('terms-of-service', 'termsOfService')->name('terms-of-service');
});

Route::middleware('auth')->controller(PageController::class)->group(function (): void {
    Route::get('account', 'account')->name('account.settings');
});

Route::middleware('auth')->controller(ProfileController::class)->prefix('account/profile')->name('account.profile.')->group(function (): void {
    Route::get('/', 'show')->name('show');
    Route::put('/', 'update')->name('update');
});

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
