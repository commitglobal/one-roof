<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\RequestResource\Actions;

use Filament\Actions\DeleteAction as Action;

class DeleteAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'delete';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->groupedIcon(null);

        $this->label(__('app.request.actions.delete.button'));

        $this->modalHeading(__('app.request.actions.delete.confirm.title'));

        $this->modalDescription(__('app.request.actions.delete.confirm.description'));

        $this->modalWidth('md');

        $this->successNotificationTitle(__('app.request.actions.delete.confirm.success'));
    }
}
