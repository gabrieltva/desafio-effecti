<?php

namespace Database\Factories;

use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'cpf' => fake()->cpf(),
            'birth_date' => fake()->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
            'email' => fake()->email(),
            'phone' => fake()->cellPhoneNumber(),
            'cep' => fake()->postcode(),
            'state' => fake()->stateAbbr(),
            'city' => fake()->city(),
            'neighborhood' => fake()->citySuffix(),
            'address' => fake()->address(),
            'status' => fake()->randomElement([UserStatus::Inactive, UserStatus::Active]),
        ];
    }
}
