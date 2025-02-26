<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\RelationManagers;

use App\Enums\Status;
use App\Filament\Admin\Resources\OrganizationResource\Schemas\AdminsForm;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AdminsRelationManager extends RelationManager
{
    protected static string $relationship = 'admins';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(AdminsForm::getIndividualSchema());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('app.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('app.field.email'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('app.field.status'))
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('app.field.status'))
                    ->options(Status::options()),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }
}
