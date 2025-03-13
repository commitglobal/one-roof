<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ShelterAttributeResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VariablesRelationManager extends RelationManager
{
    protected static string $relationship = 'variables';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('id')
                    ->label(__('app.field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->shrink(),

                TextColumn::make('order')
                    ->label(__('app.field.order'))
                    ->sortable()
                    ->shrink(),

                TextColumn::make('name')
                    ->label(__('app.field.variable_name'))
                    ->sortable(),

                IconColumn::make('is_enabled')
                    ->label(__('app.field.active'))
                    ->boolean(),

            ])
            ->reorderable('order')
            ->defaultSort('order', 'asc')
            ->paginated(false);
    }
}
