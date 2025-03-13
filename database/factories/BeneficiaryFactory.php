<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\IDType;
use App\Models\Beneficiary;
use App\Models\Country;
use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beneficiary>
 */
class BeneficiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'date_of_birth' => fake()->date(),
            'gender' => fake()->randomElement(Gender::values()),
            'nationality_id' => Country::inRandomOrder()->first()->id,
            'id_type' => fake()->randomElement(IDType::values()),
            'id_number' => fake()->numerify('##########'),
            'residence_country_id' => Country::inRandomOrder()->first()->id,
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'notes' => fake()->optional()->text(200),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Beneficiary $beneficiary) {
            Document::factory()
                ->count(3)
                ->for($beneficiary)
                ->create();
        });
    }
}
