<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ShelterAttributeResource\Actions;

use App\Models\ShelterAttribute;
use Filament\Actions\Action;
use Filament\Facades\Filament;

class DeactivateAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'deactivate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (ShelterAttribute $record) => $record->isActive() && Filament::auth()->user()->can('update', $record));

        $this->label(__('app.attribute.actions.deactivate.button'));

        $this->color('danger');

        $this->icon('heroicon-o-user-minus');

        $this->outlined();

        $this->modalHeading(__('app.attribute.actions.deactivate.confirm.title'));

        $this->modalDescription(__('app.attribute.actions.deactivate.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (ShelterAttribute $record) {
            $record->deactivate();
            $this->success();
        });

        $this->successNotificationTitle(__('app.attribute.actions.deactivate.confirm.success'));
    }
}
