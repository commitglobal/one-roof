<?php

declare(strict_types=1);

namespace Database\Factories\Form;

use App\Models\Form\Field;
use App\Models\Form\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Form\Section>
 */
class SectionFactory extends Factory
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
            'description' => fake()->sentence(),
            'order' => fake()->numberBetween(1, 10),
        ];
    }

    public function withFields(int $count = 5): static
    {
        return $this->afterCreating(function (Section $section) use ($count) {
            Field::factory()
                ->count($count)
                ->for($section)
                ->create();
        });
    }
}
