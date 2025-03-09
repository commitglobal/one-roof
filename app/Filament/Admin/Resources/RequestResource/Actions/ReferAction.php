<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\RequestResource\Actions;

use App\Models\Request;
use Filament\Actions\Action;

class ReferAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'refer';
    }

    protected function setUp(): void
    {
        parent::setUp();

        // $this->visible(fn (Request $record) => ...);

        $this->label(__('app.request.actions.refer.button'));

        $this->color('success');

        // $this->icon('heroicon-o-arrow-path');

        $this->modalHeading(__('app.request.actions.refer.confirm.title'));

        $this->modalDescription(__('app.request.actions.refer.confirm.description'));

        $this->modalWidth('md');

        // $this->action(function (Request $record) {
        //     ...
        //     $this->success();
        // });

        $this->successNotificationTitle(__('app.request.actions.refer.confirm.success'));
    }
}
