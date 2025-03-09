<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\RequestResource\Actions;

use App\Models\Request;
use Filament\Actions\Action;

class MarkAsObsoleteAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'obsolete';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Request $record) => ! $record->isObsolete());

        $this->label(__('app.request.actions.obsolete.button'));

        $this->modalHeading(__('app.request.actions.obsolete.confirm.title'));

        $this->modalDescription(__('app.request.actions.obsolete.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (Request $record) {
            $record->markAsObsolete();
            $this->success();
        });

        $this->successNotificationTitle(__('app.request.actions.obsolete.confirm.success'));
    }
}
