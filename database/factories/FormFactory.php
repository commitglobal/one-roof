<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Form\Status;
use App\Enums\Form\Type;
use App\Models\Form;
use App\Models\FormSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Form>
 */
class FormFactory extends Factory
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
            'type' => fake()->randomElement(Type::values()),
            'status' => Status::DRAFT,
            'description' => fake()->sentence(),
        ];
    }

    public function personal(): static
    {
        return $this->state([
            'type' => Type::PERSONAL,
        ]);
    }

    public function request(): static
    {
        return $this->state([
            'type' => Type::REQUEST,
        ]);
    }

    public function published(): static
    {
        return $this->state([
            'status' => Status::PUBLISHED,
        ]);
    }

    public function obsolete(): static
    {
        return $this->state([
            'status' => Status::OBSOLETE,
        ]);
    }

    public function withSections(int $count = 1): static
    {
        return $this->afterCreating(function (Form $form) use ($count) {
            FormSection::factory()
                ->count($count)
                ->for($form)
                ->create();
        });
    }
}
