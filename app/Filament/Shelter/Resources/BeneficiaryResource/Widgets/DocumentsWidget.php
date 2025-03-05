<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Widgets;

use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\DocumentForm;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\DocumentInfolist;
use App\Models\Beneficiary;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class DocumentsWidget extends BaseWidget
{
    public ?Beneficiary $record = null;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => $this->record->documents())
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

                TextColumn::make('type')
                    ->label(__('app.field.document_type'))
                    ->sortable()
                    ->shrink(),

                TextColumn::make('name')
                    ->label(__('app.field.document_name'))
                    ->sortable()
                    ->wrap()
                    ->limit(),

                TextColumn::make('notes')
                    ->label(__('app.field.notes'))
                    ->wrap()
                    ->limit(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form(DocumentForm::getSchema($this->record->id)),
            ])
            ->actions([
                ViewAction::make()
                    ->infolist(DocumentInfolist::getSchema()),
            ]);
    }
}
