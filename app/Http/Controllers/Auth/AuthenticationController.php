<?php

namespace App\Http\Controllers\Auth;

use App\Enums\SocialiteProvidersEnum;
use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use App\Notifications\LoginOtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthenticationController extends Controller
{
    public function showLogin(): Response
    {
        return Inertia::render('Auth/Login', [
            'providers' => collect(SocialiteProvidersEnum::cases())
                ->map(fn(SocialiteProvidersEnum $provider): array => [
                    'value' => $provider->value,
                    'label' => $provider->label(),
                ])
                ->values(),
        ]);
    }

    public function showOtp(Request $request): Response|RedirectResponse
    {
        $email = $request->session()->get('auth.otp.email');

        if (! is_string($email)) {
            return to_route('auth.login');
        }

        return Inertia::render('Auth/VerifyOtp', [
            'email' => $email,
        ]);
    }

    public function requestOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);
        $email = Str::lower($validated['email']);
        $throttleKey = 'auth.otp.request.' . sha1($email . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            throw ValidationException::withMessages([
                'email' => 'Please wait before requesting another code.',
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        $code = (string) random_int(100000, 999999);
        Cache::put($this->otpKey($email), hash('sha256', $code), now()->addMinutes(10));
        $request->session()->put('auth.otp.email', $email);

        Notification::route('mail', $email)->notify(new LoginOtpNotification($code));

        return to_route('auth.otp.show');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $email = $request->session()->get('auth.otp.email');

        if (! is_string($email)) {
            return to_route('auth.login');
        }

        $validated = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);
        $storedCode = Cache::pull($this->otpKey($email));

        if (! is_string($storedCode) || ! hash_equals($storedCode, hash('sha256', $validated['code']))) {
            throw ValidationException::withMessages([
                'code' => 'That code is invalid or has expired.',
            ]);
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => Str::before($email, '@'),
                'email_verified_at' => now(),
            ],
        );

        if ($user->email_verified_at === null) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->forget('auth.otp.email');

        return to_route('home');
    }

    public function redirectToProvider(SocialiteProvidersEnum $provider): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return Socialite::driver($provider->value)->redirect();
    }

    public function handleProviderCallback(Request $request, SocialiteProvidersEnum $provider): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($provider->value)->user();
        } catch (Throwable) {
            return to_route('auth.login')->withErrors([
                'social' => 'We could not sign you in with that provider.',
            ]);
        }

        $socialAccount = SocialAccount::query()
            ->where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        $user = $socialAccount?->user;

        if ($user === null && is_string($socialUser->getEmail())) {
            $user = User::firstOrCreate(
                ['email' => Str::lower($socialUser->getEmail())],
                [
                    'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: 'Golf fan',
                    'email_verified_at' => now(),
                ],
            );
        }

        if ($user === null) {
            return to_route('auth.login')->withErrors([
                'social' => 'This provider did not return an email address.',
            ]);
        }

        $socialAccount = SocialAccount::firstOrNew(
            [
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ],
        );
        $socialAccount->user()->associate($user);
        $socialAccount->save();

        Auth::login($user, true);
        $request->session()->regenerate();

        return to_route('home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('home');
    }

    private function otpKey(string $email): string
    {
        return 'auth.otp.' . hash('sha256', $email);
    }
}
