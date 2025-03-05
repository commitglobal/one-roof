<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Widgets;

use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\StayForm;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\StayInfolist;
use App\Models\Beneficiary;
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
            ])
            ->headerActions([
                CreateAction::make()
                    ->form(StayForm::getSchema($this->record->id)),
            ])
            ->actions([
                ViewAction::make()
                    ->infolist(StayInfolist::getSchema()),
            ]);
    }
}
