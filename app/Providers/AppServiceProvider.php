<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Head\Facades\Head;
use Laravel\Head\HeadBuilder;
use SocialiteProviders\Apple\Provider as AppleProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite('apple', AppleProvider::class);
        });

        $this->configureDefaults();
        $this->configureHead();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn(): ?Password => app()->isProduction()
                ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
                : null,
        );
    }

    protected function configureHead(): void
    {
        Head::defaults(
            fn(HeadBuilder $head): HeadBuilder => $head
                ->title(config('app.name', 'Must Have Golf'), suffix: ' - ' . config('app.name', 'Must Have Golf'))
                ->description('Build and discover better golf setups with Must Have Golf.')
                ->canonical()
                ->og(siteName: config('app.name', 'Must Have Golf'))
                ->searchableByRobots()
        );

        Head::inertiaGlobals(
            fn(HeadBuilder $head): HeadBuilder => $head
                ->viewport('width=device-width, initial-scale=1')
                ->colorScheme('light dark')
        );
    }
}
