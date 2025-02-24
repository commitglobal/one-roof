<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Data\PersonData;
use App\Enums\OrganizationType;
use App\Enums\Status;
use App\Models\Country;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'legal_name' => fake()->company(),
            'country_id' => Country::inRandomOrder()->first()?->id,
            'location_id' => Location::inRandomOrder()->first()?->id,
            'address' => fake()->address(),
            'type' => fake()->randomElement(OrganizationType::values()),
            'representative' => new PersonData(
                name: fake()->name(),
                email: fake()->email(),
                phone: fake()->phoneNumber(),
            ),

            'contact' => new PersonData(
                name: fake()->name(),
                email: fake()->email(),
                phone: fake()->phoneNumber(),
            ),
            'notes' => fake()->paragraph(),
            'status' => fake()->randomElement(Status::values()),
        ];
    }
}
