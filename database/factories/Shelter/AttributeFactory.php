<?php

declare(strict_types=1);

namespace Database\Factories\Shelter;

use App\Enums\AttributeType;
use App\Models\Shelter\Attribute;
use App\Models\Shelter\Variable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
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
        return $this->afterCreating(function (Attribute $attribute) {
            Variable::factory()
                ->count(3)
                ->for($attribute, 'attribute')
                ->create();
        });
    }
}
