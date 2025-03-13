<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Status;
use App\Enums\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->e164PhoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'status' => Status::ACTIVE,
            'password_set_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'password_set_at' => null,
            'status' => Status::PENDING,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Status::INACTIVE,
        ]);
    }

    /**
     * Indicate that the model should have super admin role.
     */
    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::SUPER_ADMIN,
        ]);
    }

    /**
     * Indicate that the model should have super user role.
     */
    public function superUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::SUPER_USER,
        ]);
    }

    /**
     * Indicate that the model should have shelter admin role.
     */
    public function shelterAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            // 'role' => Role::SHELTER_ADMIN,
        ]);
    }

    /**
     * Indicate that the model should have shelter user role.
     */
    public function shelterUser(): static
    {
        return $this->state(fn (array $attributes) => [
            // 'role' => Role::SHELTER_USER,
        ]);
    }
}
