<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Widgets;

use App\Filament\Shelter\Resources\BeneficiaryResource;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\StayForm;
use App\Filament\Shelter\Resources\RequestResource;
use App\Models\Beneficiary;
use App\Models\Stay;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class StaysWidget extends BaseWidget
{
    public ?Beneficiary $record = null;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => $this->record->stays())
            ->columns([
                TextColumn::make('id')
                    ->label(__('app.field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->shrink(),

                TextColumn::make('start_date')
                    ->label(__('app.field.start_date'))
                    ->date()
                    ->sortable()
                    ->shrink(),

                TextColumn::make('end_date')
                    ->label(__('app.field.end_date'))
                    ->date()
                    ->sortable()
                    ->shrink(),

                TextColumn::make('shelter.name')
                    ->label(__('app.field.shelter'))
                    ->sortable()
                    ->shrink(),

                TextColumn::make('group.title')
                    ->label(__('app.field.group'))
                    ->url(function (Stay $record) {
                        if (blank($record->group_id)) {
                            return null;
                        }

                        // TODO: use action to open infolist modal
                        return '#';
                    })
                    ->color('primary')
                    ->wrap()
                    ->shrink(),

                TextColumn::make('request.title')
                    ->label(__('app.field.request'))
                    ->url(function (Stay $record) {
                        if (blank($record->request_id)) {
                            return null;
                        }

                        return RequestResource::getUrl('view', [
                            'record' => $record->request_id,
                        ]);
                    })
                    ->color('primary')
                    ->shrink(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form(StayForm::getSchema($this->record->id)),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn (Stay $record) => BeneficiaryResource::getUrl('stay', [
                        'record' => $this->record,
                        'stay' => $record,
                    ])),
            ]);
    }
}
