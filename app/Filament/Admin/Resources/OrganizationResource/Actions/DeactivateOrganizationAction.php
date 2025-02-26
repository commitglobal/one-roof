<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Actions;

use App\Models\Organization;
use Filament\Actions\Action;
use Filament\Facades\Filament;

class DeactivateOrganizationAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'deactivate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Organization $record) => $record->isActive() && Filament::auth()->user()->can('update', $record));

        $this->label(__('app.organization.actions.deactivate.button'));

        $this->color('danger');

        $this->icon('heroicon-o-user-minus');

        $this->outlined();

        $this->modalHeading(__('app.organization.actions.deactivate.confirm.title'));

        $this->modalDescription(__('app.organization.actions.deactivate.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (Organization $record) {
            $record->deactivate();
            $this->success();
        });

        $this->successNotificationTitle(__('app.organization.actions.deactivate.confirm.success'));
    }
}
