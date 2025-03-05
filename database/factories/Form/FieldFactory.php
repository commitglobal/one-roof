<?php

declare(strict_types=1);

namespace Database\Factories\Form;

use App\Enums\Form\FieldType;
use App\Models\Form\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Form\Field>
 */
class FieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(FieldType::cases());

        $attributes = [
            'type' => $type,
            'section_id' => Section::factory(),
            'label' => fake()->words(3, asText: true),
            'help' => fake()->sentence(),
            'required' => fake()->boolean(),
            'order' => fake()->numberBetween(1, 10),
        ];

        if (\in_array($type, [FieldType::CHECKBOX, FieldType::RADIO, FieldType::SELECT])) {
            $attributes['options'] = collect(fake()->words(3))
                ->join("\n");
        }

        if (\in_array($type, [FieldType::NUMBER, FieldType::TEXT, FieldType::TEXTAREA])) {
            $attributes['min'] = fake()->numberBetween(1, 10);
            $attributes['max'] = fake()->numberBetween(500, 600);
        }

        return $attributes;
    }
}
