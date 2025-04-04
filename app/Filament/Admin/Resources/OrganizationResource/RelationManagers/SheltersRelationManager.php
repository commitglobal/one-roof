<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\RelationManagers;

use App\Filament\Admin\Resources\OrganizationResource\Schemas\SheltersForm;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class SheltersRelationManager extends RelationManager
{
    protected static string $relationship = 'shelters';

    public function form(Form $form): Form
    {
        return $form
            ->schema(SheltersForm::getIndividualSchema());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ToggleColumn::make('is_listed')
                    ->label(__('app.field.is_listed'))
                    ->shrink(),

                TextColumn::make('name')
                    ->label(__('app.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('capacity')
                    ->label(__('app.field.capacity'))
                    ->sortable()
                    ->numeric()
                    ->alignRight()
                    ->shrink(),

                TextColumn::make('country.name')
                    ->label(__('app.field.country'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location.name')
                    ->label(__('app.field.location'))
                    ->lineClamp(2)
                    ->limit(100)
                    ->wrap()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
