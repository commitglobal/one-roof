<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Widgets;

use App\Filament\Shelter\Resources\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\Form\Response;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PersonalDataVersionsWidget extends BaseWidget
{
    public ?Beneficiary $record = null;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => $this->record->personal())
            ->columns([
                TextColumn::make('id')
                    ->label(__('app.field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->shrink(),

                TextColumn::make('created_at')
                    ->label(__('app.field.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->shrink(),

                TextColumn::make('updated_at')
                    ->label(__('app.field.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->shrink(),

            ])
            ->actions([
                ViewAction::make()
                    ->url(fn (Response $record) => BeneficiaryResource::getUrl('versions.view', [
                        'record' => $this->record,
                        'response' => $record,
                    ])),
            ]);
    }
}
