<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ShelterAttributeResource\Actions;

use App\Models\ShelterAttribute;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;

class UnlistAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'unlist';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (ShelterAttribute $record) => $record->isListed() && Filament::auth()->user()->can('update', $record));

        $this->label(__('app.attribute.actions.unlist.button'));

        $this->color('danger');

        $this->icon('heroicon-o-eye-slash');

        $this->outlined();

        $this->requiresConfirmation();

        $this->modalHeading(__('app.attribute.actions.unlist.confirm.title'));

        $this->modalDescription(__('app.attribute.actions.unlist.confirm.description'));

        $this->action(function (ShelterAttribute $record) {
            $record->unlist();
            $this->success();
        });

        $this->successNotificationTitle(__('app.attribute.actions.unlist.confirm.success'));
    }
}
