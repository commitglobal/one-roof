<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LocationResource\Actions\MergeLocationsBulkAction;
use App\Filament\Admin\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LocationResource extends Resource
{
    use Translatable;

    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?int $navigationSort = 21;

    public static function getNavigationGroup(): ?string
    {
        return __('app.navigation.configurations');
    }

    public static function getModelLabel(): string
    {
        return __('app.location.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.location.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('app.field.name'))
                    ->columnSpanFull()
                    ->maxLength(100)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('app.field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->shrink(),

                TextColumn::make('name')
                    ->label(__('app.field.name'))
                    ->lineClamp(2)
                    ->limit(100)
                    ->wrap()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                MergeLocationsBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLocations::route('/'),
        ];
    }
}
