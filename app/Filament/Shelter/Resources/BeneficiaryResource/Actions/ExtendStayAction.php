<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Actions;

use App\Models\Stay;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;

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
                'stay' => $record->id,
                'start_date' => $record->start_date->toFormattedDate(),
                'end_date' => $record->end_date->toFormattedDate(),
            ])
        );

        $this->modalDescription(__('app.stay.actions.extend.confirm.description'));

        $this->modalWidth('md');

        $this->form([
            DatePicker::make('end_date')
                ->label(__('app.field.end_date'))
                ->after(fn (Stay $record) => $record->end_date->toDateString())
                ->default(fn (Stay $record) => $record->end_date->toDateString())
                ->required(),
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
