<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AddressType;
use App\Models\Country;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'country_code' => Country::inRandomOrder()->first()->code,
            'zip_code' => substr(preg_replace('/[^0-9]/', '', fake()->postcode()), 0, 6),
            'street_address' => fake()->streetAddress(),
            'address_type' => AddressType::cases()[array_rand(AddressType::cases())],
            'city' => fake()->city(),
            'company_name' => $this->faker->company(),
            'tax_number' => $this->faker->randomNumber(8),
            'registration_number' => $this->faker->randomNumber(6),
            'bank_account_number' => $this->faker->bankAccountNumber(),
            'latitude' => $this->faker->randomFloat(6, -90, 90),
            'longitude' => $this->faker->randomFloat(6, -180, 180),
        ];
    }


    public function legal()
    {
        return $this->state(function (array $attributes) {
            return [
                'address_type' => AddressType::LEGAL,
            ];
        });
    }

    public function individual()
    {
        return $this->state(function (array $attributes) {
            return [
                'address_type' => AddressType::INDIVIDUAL,
            ];
        });
    }
}
