<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Data\PersonData;
use App\Models\Beneficiary;
use App\Models\Country;
use App\Models\Group;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Request;
use App\Models\Shelter;
use App\Models\ShelterVariable;
use App\Models\Stay;
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
                phone: fake()->e164PhoneNumber(),
            ),
            'notes' => fake()->paragraph(),
            'is_listed' => fake()->boolean(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Shelter $shelter) {
            $groups = Group::factory()
                ->count(10)
                ->for($shelter)
                ->create();

            $beneficiaries = Beneficiary::pluck('id')
                ->map(fn (int $id) => [
                    'beneficiary_id' => $id,
                    'group_id' => fake()->boolean() ? $groups->random()->id : null,
                ]);

            Stay::factory()
                ->count($beneficiaries->count())
                ->sequence(...$beneficiaries)
                ->for($shelter)
                ->create();

            Stay::factory()
                ->count($beneficiaries->count())
                ->sequence(...$beneficiaries)
                ->for($shelter)
                ->indefinite()
                ->create();

            Request::factory()
                ->count(10)
                ->for($shelter)
                ->create();

            $shelter->shelterVariables()->sync(
                ShelterVariable::query()
                    ->inRandomOrder()
                    ->limit(3)
                    ->pluck('id')
            );
        });
    }
}
