<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Filament\Admin\Resources\CountryResource\Pages\ManageCountries;
use App\Models\Country;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Tables\Actions\EditAction;
use Illuminate\Contracts\Auth\Authenticatable;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CountriesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel(
            Filament::getPanel('admin')
        );

        /** @var Authenticatable */
        $user = User::factory()
            ->superAdmin()
            ->create();

        $this->actingAs($user);
    }

    #[Test]
    public function superadmins_can_list_countries(): void
    {
        $countries = Country::all();

        $country = 'BR';

        Livewire::test(ManageCountries::class)
            ->assertSuccessful()
            ->assertTableColumnExists('id')
            ->assertTableColumnExists('name')
            ->assertCountTableRecords($countries->count())
            ->searchTable('BR')
            ->assertCanSeeTableRecords($countries->where('id', $country))
            ->assertCountTableRecords(1);
    }

    #[Test]
    public function superadmins_can_create_a_country(): void
    {
        Livewire::test(ManageCountries::class)
            ->callAction(CreateAction::class, [
                'id' => 'XX',
                'name' => 'Country',
            ])
            ->assertHasNoErrors()
            ->searchTable('XX')
            ->assertCanSeeTableRecords(
                Country::query()
                    ->where('id', 'XX')
                    ->get()
            );
    }

    #[Test]
    public function superadmins_cannot_create_a_duplicate_country(): void
    {
        Country::create([
            'id' => 'XX',
            'name' => 'Country',
        ]);

        Livewire::test(ManageCountries::class)
            ->callAction(CreateAction::class, [
                'id' => 'XX',
                'name' => 'Country',
            ])
            ->assertHasErrors();
    }

    #[Test]
    public function superadmins_can_update_country(): void
    {
        $country = Country::create([
            'id' => 'XX',
            'name' => 'Country',
        ]);

        Livewire::test(ManageCountries::class)
            ->callTableAction(EditAction::class, $country->id, [
                'name' => 'Updated Country',
            ])
            ->assertHasNoTableActionErrors();

        $this->assertEquals('Updated Country', $country->refresh()->name);
    }
}
