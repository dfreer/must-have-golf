<?php

namespace Database\Factories;

use App\Enums\SocialiteProvidersEnum;
use App\Models\SocialAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SocialAccount>
 */
class SocialAccountFactory extends Factory
{
    protected $model = SocialAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider' => fake()->randomElement(SocialiteProvidersEnum::cases())->value,
            'provider_id' => fake()->unique()->uuid(),
        ];
    }
}
