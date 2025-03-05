<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Data\PersonData;
use App\Models\Beneficiary;
use App\Models\Country;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Shelter;
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
        ];
    }

    public function configure(): static
    {
        $beneficiaries = Beneficiary::pluck('id')
            ->map(fn (int $id) => [
                'beneficiary_id' => $id,
            ]);

        return $this->afterCreating(function (Shelter $shelter) use ($beneficiaries) {
            Stay::factory()
                ->count($beneficiaries->count())
                ->sequence(...$beneficiaries)
                ->for($shelter)
                ->create();
        });
    }
}
