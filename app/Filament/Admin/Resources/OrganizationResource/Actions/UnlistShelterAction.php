<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Actions;

use App\Models\Shelter;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;

class UnlistShelterAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'unlist';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Shelter $record) => $record->isListed() && Filament::auth()->user()->can('update', $record));

        $this->label(__('app.shelter.actions.unlist.button'));

        $this->color('danger');

        $this->icon('heroicon-o-eye-slash');

        $this->outlined();

        $this->requiresConfirmation();

        $this->modalHeading(__('app.shelter.actions.unlist.confirm.title'));

        $this->modalDescription(__('app.shelter.actions.unlist.confirm.description'));

        $this->action(function (Shelter $record) {
            $record->unlist();
            $this->success();
        });

        $this->successNotificationTitle(__('app.shelter.actions.unlist.confirm.success'));
    }
}
