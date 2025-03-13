<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LanguageResource\Pages;
use App\Models\Language;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 40;

    public static function getNavigationGroup(): ?string
    {
        return __('app.navigation.configurations');
    }

    public static function getModelLabel(): string
    {
        return __('app.language.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.language.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label(__('app.field.code'))
                    ->unique(ignoreRecord: true)
                    ->length(2)
                    ->alpha()
                    ->live()
                    ->columnSpanFull(),

                Placeholder::make('name')
                    ->label(__('app.field.name'))
                    ->content(function (Get $get) {
                        $code = (string) $get('code');
                        $name = locale_get_display_name($code);

                        if (blank($code) || $name === $code) {
                            return '–';
                        }

                        return $name;
                    }),

                Placeholder::make('native_name')
                    ->label(__('app.field.native_name'))
                    ->content(function (Get $get) {
                        $code = (string) $get('code');
                        $name = locale_get_display_name($code, $code);

                        if (blank($code) || $name === $code) {
                            return '–';
                        }

                        return $name;
                    }),

                Toggle::make('enabled')
                    ->label(__('app.field.enabled')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('app.field.code'))
                    ->sortable()
                    ->shrink(),

                TextColumn::make('name')
                    ->label(__('app.field.name')),

                TextColumn::make('native_name')
                    ->label(__('app.field.native_name')),

                IconColumn::make('enabled')
                    ->label(__('app.field.enabled')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('code', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLanguages::route('/'),
        ];
    }
}
