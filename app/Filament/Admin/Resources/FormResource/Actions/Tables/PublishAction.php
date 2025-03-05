<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\FormResource\Actions\Tables;

use App\Models\Form;
use Filament\Tables\Actions\Action;

class PublishAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'publish';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->visible(fn (Form $record) => $record->isDraft());

        $this->label(__('app.form.actions.publish.button'));

        $this->color('success');

        $this->icon('heroicon-o-arrow-path');

        $this->outlined();

        $this->modalHeading(__('app.form.actions.publish.confirm.title'));

        $this->modalDescription(__('app.form.actions.publish.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (Form $record) {
            $record->markAsPublished();

            $this->success();
        });

        $this->successNotificationTitle(__('app.form.actions.publish.confirm.success'));
    }
}
