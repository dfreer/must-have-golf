<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_pages_are_available(): void
    {
        $this->get(route('auth.login'))->assertOk();

        $this->withSession(['auth.otp.email' => 'golfer@example.com'])
            ->get(route('auth.otp.show'))
            ->assertOk();
    }

    public function test_email_otp_logs_the_user_in(): void
    {
        Notification::fake();
        $email = 'golfer@example.com';
        $code = '123456';

        $this->post(route('auth.otp.request'), ['email' => $email])
            ->assertRedirect(route('auth.otp.show'));

        Cache::put(
            'auth.otp.' . hash('sha256', $email),
            hash('sha256', $code),
        );

        $this->withSession(['auth.otp.email' => $email])
            ->post(route('auth.otp.verify'), ['code' => $code])
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => $email]);
    }

    public function test_social_callback_logs_the_user_in_and_links_the_account(): void
    {
        Socialite::fake('google', SocialiteUser::fake([
            'id' => 'google-user-123',
            'name' => 'Golf Fan',
            'email' => 'golfer@example.com',
        ]));

        $this->get(route('auth.social.callback', ['provider' => 'google']))
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs(User::firstWhere('email', 'golfer@example.com'));
        $this->assertDatabaseHas('social_accounts', [
            'provider' => 'google',
            'provider_id' => 'google-user-123',
        ]);
    }

    public function test_authenticated_user_can_log_out(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('auth.logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
