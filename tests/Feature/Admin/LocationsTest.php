<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Filament\Admin\Actions\MergeBulkAction;
use App\Filament\Admin\Resources\LocationResource\Pages\ManageLocations;
use App\Models\Location;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LocationsTest extends TestCase
{
    #[Test]
    public function superadmins_can_list_locations(): void
    {
        $user = User::factory()
            ->superAdmin()
            ->create();

        $locations = Location::factory()
            ->count(10)
            ->create();

        Livewire::actingAs($user)
            ->test(ManageLocations::class)
            ->assertSuccessful()
            ->assertTableColumnExists('id')
            ->assertTableColumnExists('name')
            ->assertCountTableRecords($locations->count());
        // ->sortTable('id', 'asc')
        // ->assertCanSeeTableRecords($locations->sortBy('id'), inOrder: true)
        // ->sortTable('name', 'asc')
        // ->assertCanSeeTableRecords($locations->sortBy('name'), inOrder: true);
    }

    #[Test]
    public function superadmins_can_create_a_location(): void
    {
        $user = User::factory()
            ->superAdmin()
            ->create();

        Livewire::actingAs($user)
            ->test(ManageLocations::class)
            ->callAction(CreateAction::class, [
                'name' => fake()->word(),
            ])
            ->assertHasNoErrors()
            ->assertCountTableRecords(1);
    }

    #[Test]
    public function superadmins_can_update_a_location(): void
    {
        $user = User::factory()
            ->superAdmin()
            ->create();

        $location = Location::factory()
            ->create();

        Livewire::actingAs($user)
            ->test(ManageLocations::class)
            ->callTableAction(EditAction::class, $location->id, [
                'name' => 'Updated Location',
            ])
            ->assertHasNoTableActionErrors();

        $this->assertEquals('Updated Location', $location->refresh()->name);
    }

    #[Test]
    public function superadmins_can_bulk_merge_two_locations(): void
    {
        $user = User::factory()
            ->superAdmin()
            ->create();

        $locations = Location::factory()
            ->count(2)
            ->create();

        Livewire::actingAs($user)
            ->test(ManageLocations::class)
            ->assertCountTableRecords(2)
            ->callTableBulkAction(MergeBulkAction::class, $locations->pluck('id'))
            ->assertHasNoTableActionErrors()
            ->assertCountTableRecords(1)
            ->assertSeeText($locations->pluck('name')->join(', '));
    }
}
