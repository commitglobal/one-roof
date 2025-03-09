<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\RequestResource\Actions;

use App\Models\Request;
use Filament\Actions\Action;

class MarkAsDuplicateAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'duplicate';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Request $record) => ! $record->isDuplicate());

        $this->label(__('app.request.actions.duplicate.button'));

        $this->modalHeading(__('app.request.actions.duplicate.confirm.title'));

        $this->modalDescription(__('app.request.actions.duplicate.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (Request $record) {
            $record->markAsDuplicate();
            $this->success();
        });

        $this->successNotificationTitle(__('app.request.actions.duplicate.confirm.success'));
    }
}
