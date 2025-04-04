<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Actions;

use App\Models\Shelter;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;

class ListShelterAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'list';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Shelter $record) => $record->isUnlisted() && Filament::auth()->user()->can('update', $record));

        $this->label(__('app.shelter.actions.list.button'));

        $this->color('success');

        $this->icon('heroicon-o-eye');

        $this->outlined();

        $this->requiresConfirmation();

        $this->modalHeading(__('app.shelter.actions.list.confirm.title'));

        $this->modalDescription(__('app.shelter.actions.list.confirm.description'));

        $this->action(function (Shelter $record) {
            $record->list();
            $this->success();
        });

        $this->successNotificationTitle(__('app.shelter.actions.list.confirm.success'));
    }
}
