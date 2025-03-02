<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Data\PersonData;
use App\Enums\OrganizationType;
use App\Enums\Status;
use App\Models\Country;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Shelter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

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
                phone: fake()->e164PhoneNumber(),
            ),

            'contact' => new PersonData(
                name: fake()->name(),
                email: fake()->email(),
                phone: fake()->e164PhoneNumber(),
            ),
            'notes' => fake()->paragraph(),
            'status' => fake()->randomElement(Status::values()),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Organization $organization) {
            Shelter::factory()
                ->count(3)
                ->for($organization)
                ->create();

            User::factory()
                ->count(3)
                ->sequence(fn (Sequence $sequence) => [
                    'email' => \sprintf('user-%d-%d@example.com', $organization->id, $sequence->index + 1),
                ])
                ->for($organization)
                ->create();

            // $organization->admins()->save(User::factory()->superAdmin()->make());
        });
    }
}
