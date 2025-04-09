<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ShelterAttributeResource\Actions\ListAction;
use App\Filament\Admin\Resources\ShelterAttributeResource\Actions\UnlistAction;
use App\Filament\Admin\Resources\ShelterAttributeResource\Pages;
use App\Forms\Components\TableRepeater;
use App\Models\ShelterAttribute;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShelterAttributeResource extends Resource
{
    protected static ?string $model = ShelterAttribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 10;

    protected static ?string $slug = 'attributes';

    public static function getNavigationGroup(): ?string
    {
        return __('app.navigation.configurations');
    }

    public static function getModelLabel(): string
    {
        return __('app.attribute.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.attribute.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('app.field.name'))
                            ->required()
                            ->translatable(),

                        TableRepeater::make('variables')
                            ->label(__('app.field.variables'))
                            ->relationship('shelterVariables')
                            ->deletable(function () {
                                // TODO: implement based on usage
                                return false;
                            })
                            ->orderColumn('order')
                            ->headers([
                                Header::make('name')
                                    ->label(__('app.field.name'))
                                    ->markAsRequired(),

                                Header::make('is_enabled')
                                    ->label(__('app.field.active'))
                                    ->width('80px'),
                            ])
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('app.field.name'))
                                    ->required()
                                    ->translatable(),

                                Toggle::make('is_enabled')
                                    ->label(__('app.field.active'))
                                    ->default(true),
                            ]),
                    ]),
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
                    ->searchable()
                    ->sortable(),

                TextColumn::make('shelter_variables_count')
                    ->label(__('app.field.variables'))
                    ->counts('shelterVariables')
                    ->sortable()
                    ->numeric()
                    ->alignRight()
                    ->shrink(),

                // TextColumn::make('shelters_count')
                //     ->label(__('app.field.usage'))
                //     ->counts('shelters')
                //     ->sortable(),

                IconColumn::make('is_enabled')
                    ->label(__('app.field.active'))
                    ->boolean()
                    ->shrink(),

                IconColumn::make('is_listed')
                    ->label(__('app.field.is_listed'))
                    ->boolean()
                    ->shrink(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),

                    Tables\Actions\EditAction::make(),

                    ListAction::make(),

                    UnlistAction::make(),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShelterAttributes::route('/'),
            'create' => Pages\CreateShelterAttribute::route('/create'),
            'view' => Pages\ViewShelterAttribute::route('/{record}'),
            'edit' => Pages\EditShelterAttribute::route('/{record}/edit'),
        ];
    }
}
