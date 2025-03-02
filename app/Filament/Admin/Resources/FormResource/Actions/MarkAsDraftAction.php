<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\FormResource\Actions;

use App\Models\Form;
use App\Models\Organization;
use Filament\Actions\Action;

class MarkAsDraftAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'draft';
    }

    protected function setUp(): void
    {
        parent::setUp();

        // TODO: check for responses
        $this->visible(fn (Form $record) => $record->isPublished());

        $this->label(__('app.form.actions.draft.button'));

        $this->color('success');

        $this->icon('heroicon-o-arrow-path');

        $this->outlined();

        $this->modalHeading(__('app.form.actions.draft.confirm.title'));

        $this->modalDescription(__('app.form.actions.draft.confirm.description'));

        $this->modalWidth('md');

        $this->action(function (Organization $record) {
            $record->markAsDraft();

            $this->success();
        });

        $this->successNotificationTitle(__('app.form.actions.draft.confirm.success'));
    }
}
