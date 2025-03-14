<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ShelterAttributeResource\Actions;

use App\Models\ShelterAttribute;
use Filament\Actions\Action;
use Filament\Facades\Filament;

class ActivateAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'activate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (ShelterAttribute $record) => $record->isInactive() && Filament::auth()->user()->can('update', $record));

        $this->label(__('app.attribute.actions.activate.button'));

        $this->color('success');

        $this->icon('heroicon-o-arrow-path');

        $this->outlined();

        $this->modalHeading(__('app.attribute.actions.activate.confirm.title'));

        $this->modalDescription(__('app.attribute.actions.activate.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (ShelterAttribute $record) {
            $record->activate();
            $this->success();
        });

        $this->successNotificationTitle(__('app.attribute.actions.activate.confirm.success'));
    }
}
