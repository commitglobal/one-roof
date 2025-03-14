<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ShelterVariable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShelterVariable>
 */
class ShelterVariableFactory extends Factory
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
            'order' => fake()->numberBetween(1, 10),
            'shelter_attribute_id' => ShelterVariable::factory(),
        ];
    }

    public function disabled(): static
    {
        return $this->state([
            'is_enabled' => false,
        ]);
    }
}
