<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\RequestResource\Actions;

use App\Models\Request;
use Filament\Actions\Action;

class AcceptAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'accept';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Request $record) => ! $record->isAccepted());

        $this->label(__('app.request.actions.accept.button'));

        $this->color('success');

        // $this->icon('heroicon-o-arrow-path');

        $this->modalHeading(__('app.request.actions.accept.confirm.title'));

        $this->modalDescription(__('app.request.actions.accept.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (Request $record) {
            $record->accept();
            $this->success();
        });

        $this->successNotificationTitle(__('app.request.actions.accept.confirm.success'));
    }
}
