<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\RequestResource\Actions;

use App\Models\Request;
use Filament\Actions\Action;

class MarkAsPendingAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'pending';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Request $record) => ! $record->isPending());

        $this->label(__('app.request.actions.pending.button'));

        $this->modalHeading(__('app.request.actions.pending.confirm.title'));

        $this->modalDescription(__('app.request.actions.pending.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (Request $record) {
            $record->markAsPending();
            $this->success();
        });

        $this->successNotificationTitle(__('app.request.actions.pending.confirm.success'));
    }
}
