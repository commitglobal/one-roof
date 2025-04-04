<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AttributeType;
use App\Models\ShelterAttribute;
use App\Models\ShelterVariable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShelterAttribute>
 */
class ShelterAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'is_enabled' => true,
            'type' => AttributeType::ATTRIBUTE,
            'is_listed' => fake()->boolean(),
        ];
    }

    public function disabled(): static
    {
        return $this->state([
            'is_enabled' => false,
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (ShelterAttribute $shelterAttribute) {
            ShelterVariable::factory()
                ->state([
                    'is_enabled' => $shelterAttribute->is_enabled,
                ])
                ->count(3)
                ->for($shelterAttribute)
                ->create();
        });
    }
}
