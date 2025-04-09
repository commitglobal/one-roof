<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ShelterAttributeResource\Actions;

use App\Models\ShelterAttribute;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;

class ListAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'list';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (ShelterAttribute $record) => $record->isUnlisted() && Filament::auth()->user()->can('update', $record));

        $this->label(__('app.attribute.actions.list.button'));

        $this->color('success');

        $this->icon('heroicon-o-eye');

        $this->outlined();

        $this->requiresConfirmation();

        $this->modalHeading(__('app.attribute.actions.list.confirm.title'));

        $this->modalDescription(__('app.attribute.actions.list.confirm.description'));

        $this->action(function (ShelterAttribute $record) {
            $record->list();
            $this->success();
        });

        $this->successNotificationTitle(__('app.attribute.actions.list.confirm.success'));
    }
}
