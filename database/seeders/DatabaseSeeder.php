<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Beneficiary;
use App\Models\Form;
use App\Models\Location;
use App\Models\Organization;
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

        User::factory(['email' => 'superadmin@example.com'])
            ->superAdmin()
            ->create();

        User::factory(['email' => 'superuser@example.com'])
            ->superUser()
            ->create();

        $this->forms();

        Location::factory()
            ->count(50)
            ->create();

        Beneficiary::factory()
            ->count(50)
            ->create();

        Organization::factory()
            ->count(10)
            ->create();
    }

    protected function forms(): void
    {
        Form::factory()
            ->personal()
            ->create();

        Form::factory()
            ->personal()
            ->obsolete()
            ->create();

        Form::factory()
            ->personal()
            ->published()
            ->withSections(3)
            ->create();

        Form::factory()
            ->request()
            ->create();

        Form::factory()
            ->request()
            ->obsolete()
            ->create();

        Form::factory()
            ->request()
            ->published()
            ->withSections(3)
            ->create();
    }
}
