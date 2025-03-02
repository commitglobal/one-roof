<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Schemas;

use App\Forms\Components\Repeater;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class SheltersForm
{
    public static function getSchema(): array
    {
        return [
            Repeater::make('shelters')
                ->label(__('app.field.shelters'))
                ->hiddenLabel()
                ->relationship('shelters')
                ->minItems(1)
                ->schema(static::getIndividualSchema()),
        ];
    }

    public static function getIndividualSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    TextInput::make('name')
                        ->label(__('app.field.name'))
                        ->required(),

                    TextInput::make('capacity')
                        ->label(__('app.field.capacity'))
                        ->integer()
                        ->minValue(0)
                        ->maxValue(10_000_000)
                        ->required(),

                    Select::make('country_id')
                        ->relationship('country', 'name')
                        ->label(__('app.field.country'))
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('location_id')
                        ->relationship('location', 'name')
                        ->label(__('app.field.location'))
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')
                                ->label(__('app.field.name'))
                                ->required(),
                        ])
                        ->required(),

                    TextInput::make('address')
                        ->label(__('app.field.address'))
                        ->required()
                        ->columnSpanFull(),

                    Fieldset::make(__('app.field.shelter_coordinator'))
                        ->columns(3)
                        ->schema([
                            TextInput::make('coordinator.name')
                                ->label(__('app.field.name'))
                                ->required(),

                            TextInput::make('coordinator.email')
                                ->label(__('app.field.email'))
                                ->email()
                                ->required(),

                            TextInput::make('coordinator.phone')
                                ->label(__('app.field.phone'))
                                ->tel()
                                ->required(),
                        ]),

                    Textarea::make('notes')
                        ->label(__('app.field.notes'))
                        ->rows(5)
                        ->columnSpanFull(),
                ]),
        ];
    }
}
