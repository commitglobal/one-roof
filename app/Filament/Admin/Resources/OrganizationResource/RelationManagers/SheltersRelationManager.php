<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\RelationManagers;

use App\Filament\Admin\Resources\OrganizationResource\Actions\ListShelterAction;
use App\Filament\Admin\Resources\OrganizationResource\Actions\UnlistShelterAction;
use App\Filament\Admin\Resources\OrganizationResource\Schemas\SheltersForm;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                IconColumn::make('is_listed')
                    ->label(__('app.field.is_listed'))
                    ->boolean()
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

                TextColumn::make('current_stays_count')
                    ->label(__('app.field.occupancy'))
                    ->counts([
                        'stays as current_stays_count' => fn (Builder $query) => $query->whereCurrent(),
                    ])
                    ->sortable()
                    ->numeric()
                    ->alignRight()
                    ->shrink(),

                TextColumn::make('stays_count')
                    ->label(__('app.field.all_time_beneficiaries'))
                    ->counts('stays')
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),

                    Tables\Actions\EditAction::make(),

                    ListShelterAction::make(),

                    UnlistShelterAction::make(),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ]);
    }
}
