<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Filament\Admin\Resources\OrganizationResource\Pages\CreateOrganization;
use App\Filament\Admin\Resources\OrganizationResource\Pages\EditOrganization;
use App\Filament\Admin\Resources\OrganizationResource\Pages\ListOrganizations;
use App\Models\Location;
use App\Models\Organization;
use App\Models\Shelter;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OrganizationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel(
            Filament::getPanel('admin')
        );

        Location::factory()
            ->count(10)
            ->create();

        /** @var Authenticatable */
        $user = User::factory()
            ->superAdmin()
            ->create();

        $this->actingAs($user);
    }

    #[Test]
    public function superadmins_can_list_organizations(): void
    {
        $organizations = Organization::factory()
            ->count(10)
            ->create();

        Livewire::test(ListOrganizations::class)
            ->assertSuccessful()
            ->assertTableColumnExists('name')
            ->assertTableColumnExists('country.name')
            ->assertTableColumnExists('location.name')
            ->assertTableColumnExists('status')
            ->assertCountTableRecords($organizations->count())

            // Sorting by name
            ->sortTable('name', 'asc')
            ->assertCanSeeTableRecords($organizations->sortBy('name'), inOrder: true)
            ->sortTable('name', 'desc')
            ->assertCanSeeTableRecords($organizations->sortByDesc('name'), inOrder: true)

            // Searching by name
            ->searchTable($organizations->first()->name)
            ->assertCanSeeTableRecords($organizations->where('name', $organizations->first()->name))
            ->assertCanNotSeeTableRecords($organizations->where('name', '!=', $organizations->first()->name));
    }

    #[Test]
    public function superadmins_can_create_an_organization(): void
    {
        $organization = Organization::factory()
            ->make();

        $shelters = Shelter::factory()
            ->withoutParents()
            ->count(2)
            ->make();

        $admins = User::factory()
            ->count(2)
            ->make();

        $this->assertDatabaseEmpty(Organization::class);

        Livewire::test(CreateOrganization::class)
            ->assertWizardCurrentStep(1)

            // Details
            ->fillForm($organization->toArray())
            ->goToNextWizardStep()
            ->assertHasNoFormErrors()
            ->assertWizardCurrentStep(2)

            // Shelters
            ->set('data.shelters', null)
            ->fillForm([
                'shelters' => $shelters->toArray(),
            ])
            ->goToNextWizardStep()
            ->assertHasNoFormErrors()

            // Admins
            ->set('data.admins', null)
            ->fillForm([
                'admins' => $admins
                    ->map->only('name', 'email', 'phone')
                    ->toArray(),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Organization::class, $organization->only('name'));
        $this->assertDatabaseCount(Shelter::class, $shelters->count());
        $this->assertDatabaseCount(User::class, $admins->count() + 1);
    }

    #[Test]
    public function superadmins_can_update_an_organization(): void
    {
        $organization = Organization::factory()
            ->create();

        Livewire::test(EditOrganization::class, ['record' => $organization->getRouteKey()])
            ->assertFormSet($organization->toArray())
            ->fillForm([
                'name' => 'Updated Organization',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas(Organization::class, $organization->refresh()->only('name'));
    }

    #[Test]
    public function superadmins_can_delete_an_organization(): void
    {
        $organization = Organization::factory()
            ->create();

        $this->assertDatabaseHas(Organization::class, $organization->only('name'));

        Livewire::test(EditOrganization::class, ['record' => $organization->getRouteKey()])
            ->assertFormSet($organization->toArray())
            ->callAction(DeleteAction::class)
            ->assertHasNoActionErrors();

        $this->assertDatabaseEmpty(Organization::class);
    }
}
