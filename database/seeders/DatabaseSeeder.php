<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Beneficiary;
use App\Models\Form;
use App\Models\Language;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Request;
use App\Models\ShelterAttribute;
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

        Language::create(['code' => 'es', 'enabled' => true]);

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

        ShelterAttribute::factory()
            ->count(5)
            ->create();

        ShelterAttribute::factory()
            ->count(2)
            ->disabled()
            ->create();

        Beneficiary::factory()
            ->count(50)
            ->create();

        Organization::factory()
            ->count(10)
            ->create();

        Request::factory()
            ->count(50)
            ->create();
    }

    protected function forms(): void
    {
        Form::factory()
            ->personal()
            ->withSections(1)
            ->create();

        Form::factory()
            ->personal()
            ->obsolete()
            ->withSections(1)
            ->create();

        Form::factory()
            ->personal()
            ->published()
            ->withSections(1)
            ->create();

        Form::factory()
            ->request()
            ->withSections(1)
            ->create();

        Form::factory()
            ->request()
            ->obsolete()
            ->withSections(1)
            ->create();

        Form::factory()
            ->request()
            ->published()
            ->withSections(1)
            ->create();
    }
}
