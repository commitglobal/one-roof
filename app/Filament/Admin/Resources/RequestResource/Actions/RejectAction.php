<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\RequestResource\Actions;

use App\Models\Request;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;

class RejectAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'reject';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Request $record) => ! $record->isRejected());

        $this->label(__('app.request.actions.reject.button'));

        $this->modalHeading(__('app.request.actions.reject.confirm.title'));

        $this->modalDescription(__('app.request.actions.reject.confirm.description'));

        $this->modalWidth('md');

        $this->color('danger');

        $this->form([
            Textarea::make('reason_rejected')
                ->label(__('app.field.notes'))
                ->rows(5)
                ->required(),
        ]);

        $this->action(function (Request $record, array $data) {
            $record->reject(data_get($data, 'reason_rejected'));

            $this->success();
        });

        $this->successNotificationTitle(__('app.request.actions.reject.confirm.success'));
    }
}
