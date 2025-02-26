<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Data\PersonData;
use App\Models\Country;
use App\Models\Location;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shelter>
 */
class ShelterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(asText: true),
            'capacity' => fake()->numberBetween(0, 1_000_000),
            'organization_id' => Organization::factory(),
            'country_id' => Country::inRandomOrder()->first()?->id,
            'location_id' => Location::inRandomOrder()->first()?->id,
            'address' => fake()->address(),
            'coordinator' => new PersonData(
                name: fake()->name(),
                email: fake()->email(),
                phone: fake()->phoneNumber(),
            ),
            'notes' => fake()->paragraph(),
        ];
    }
}
