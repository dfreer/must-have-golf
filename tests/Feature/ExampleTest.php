<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_pages_return_successful_responses(): void
    {
        foreach (
            [
                'home',
                'builder',
                'products',
                'guides',
                'completed-builds',
                'about',
                'affiliate-disclosure',
                'contact',
                'privacy-policy',
                'terms-of-service',
            ] as $routeName
        ) {
            $response = $this->get(route($routeName));

            $response->assertSuccessful();
        }
    }

    public function test_profile_and_account_pages_require_authentication(): void
    {
        $this->get(route('account.profile.show'))->assertRedirect(route('auth.login'));
        $this->get(route('account.settings'))->assertRedirect(route('auth.login'));
    }
}
