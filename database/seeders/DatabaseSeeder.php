<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Mail::fake();

        User::factory(['email' => 'admin@example.com'])
            ->superAdmin()
            ->create();

        Location::factory()
            ->count(50)
            ->create();
    }
}
