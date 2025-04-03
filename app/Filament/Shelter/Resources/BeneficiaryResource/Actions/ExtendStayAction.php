<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Actions;

use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\StayForm;
use App\Models\Stay;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;

class ExtendStayAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'extend';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('app.stay.actions.extend.button'));

        $this->color('success');

        $this->outlined();

        $this->icon('majestic-calendar-plus-line');

        $this->modalHeading(
            fn (Stay $record) => __('app.stay.actions.extend.confirm.title', [
                'title' => $record->title,
            ])
        );

        $this->modalDescription(__('app.stay.actions.extend.confirm.description'));

        $this->modalWidth('md');

        $this->fillForm(fn (Stay $record) => [
            'start_date' => $record->start_date,
            'end_date' => $record->end_date,
            'is_indefinite' => $record->is_indefinite,
        ]);

        $this->form([
            Hidden::make('start_date')
                ->label(__('app.field.start_date')),

            StayForm::getEndDateGroup(),
        ]);

        $this->action(function (Stay $record, array $data) {
            $record->update([
                'end_date' => data_get($data, 'end_date'),
            ]);

            $this->success();
        });

        $this->successNotificationTitle(__('app.stay.actions.extend.confirm.success'));
    }
}
