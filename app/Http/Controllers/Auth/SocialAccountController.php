<?php

namespace App\Http\Controllers\Auth;

use App\Enums\SocialiteProvidersEnum;
use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Throwable;

class SocialAccountController extends Controller
{
    public function show(SocialiteProvidersEnum $provider): SymfonyRedirectResponse
    {
        $this->setCallbackUrl($provider);

        return Socialite::driver($provider->value)->redirect();
    }

    public function store(Request $request, SocialiteProvidersEnum $provider): RedirectResponse
    {
        try {
            $this->setCallbackUrl($provider);
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

        $socialAccount = SocialAccount::firstOrNew([
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
        ]);
        $socialAccount->user()->associate($user);
        $socialAccount->save();

        Auth::login($user, true);
        $request->session()->regenerate();

        return to_route('home');
    }

    private function setCallbackUrl(SocialiteProvidersEnum $provider): void
    {
        Config::set(
            "services.{$provider->value}.redirect",
            route('auth.social.callback', ['provider' => $provider->value]),
        );
    }
}
