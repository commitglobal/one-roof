<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Beneficiary;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stay>
 */
class StayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = CarbonImmutable::createFromFormat('Y-m-d', fake()->date());
        $endDate = $startDate->addDays(random_int(1, 30));

        $children = fake()->optional()->randomDigitNotNull();

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'beneficiary_id' => Beneficiary::factory(),
            'children_count' => $children,
            'children_notes' => $children ? fake()->optional()->sentence() : null,
        ];
    }
}
