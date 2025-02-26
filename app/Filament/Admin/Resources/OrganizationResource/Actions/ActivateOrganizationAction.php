<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Actions;

use App\Models\Organization;
use Filament\Actions\Action;
use Filament\Facades\Filament;

class ActivateOrganizationAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'activate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Organization $record) => $record->isInactive() && Filament::auth()->user()->can('update', $record));

        $this->label(__('app.organization.actions.activate.button'));

        $this->color('success');

        $this->icon('heroicon-o-arrow-path');

        $this->outlined();

        $this->modalHeading(__('app.organization.actions.activate.confirm.title'));

        $this->modalDescription(__('app.organization.actions.activate.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (Organization $record) {
            $record->activate();
            $this->success();
        });

        $this->successNotificationTitle(__('app.organization.actions.activate.confirm.success'));
    }
}
