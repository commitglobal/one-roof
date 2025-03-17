<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Data\GroupMemberData;
use App\Data\PersonData;
use App\Enums\Gender;
use App\Enums\RequestStatus;
use App\Enums\SpecialNeed;
use App\Models\Country;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $requestForOther = fake()->boolean();
        $startDate = CarbonImmutable::createFromFormat('Y-m-d', fake()->date());
        $endDate = $startDate->addDays(random_int(1, 30));

        return [
            'status' => fake()->randomElement(RequestStatus::values()),
            'requester' => $requestForOther
                ? new PersonData(
                    name: fake()->name(),
                    email: fake()->email(),
                    phone: fake()->e164PhoneNumber(),
                )
                : null,

            'beneficiary' => new PersonData(
                name: fake()->name(),
                email: fake()->email(),
                phone: fake()->e164PhoneNumber(),
            ),

            'group' => Lottery::odds(1, 2)
                ->winner(
                    fn () => collect()
                        ->range(1, fake()->numberBetween(2, 10))
                        ->map(fn () => new GroupMemberData(
                            name: fake()->name(),
                            age: fake()->numberBetween(0, 150),
                            notes: fake()->sentence(),
                        ))
                        ->all()
                )
                ->loser(fn () => []),

            'departure_country_id' => Country::inRandomOrder()->first()?->id,
            'nationality_id' => Country::inRandomOrder()->first()?->id,

            'gender' => fake()->randomElement(Gender::values()),

            'age' => fake()->numberBetween(0, 150),

            'start_date' => $startDate,
            'end_date' => $endDate,

            'special_needs' => Lottery::odds(1, 10)
                ->winner(fn () => fake()->randomElements(SpecialNeed::values(), fake()->numberBetween(1, 3)))
                ->loser(fn () => null),

        ];
    }
}
