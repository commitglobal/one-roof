<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrganizationResource\Schemas\RequestInfolist;
use App\Filament\Admin\Resources\RequestResource\Pages;
use App\Models\Request;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    public static function getNavigationGroup(): ?string
    {
        return __('app.navigation.activity');
    }

    public static function getModelLabel(): string
    {
        return __('app.request.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.request.label.plural');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(RequestInfolist::getSchema());
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

                TextColumn::make('created_at')
                    ->label(__('app.field.created_at'))
                    ->dateTime()
                    ->sortable(),

                // TODO: shelter preference

                TextColumn::make('start_date')
                    ->label(__('app.field.start_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('app.field.end_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('group_size')
                    ->label(__('app.field.group_size'))
                    ->sortable(),

                TextColumn::make('special_needs')
                    ->label(__('app.field.special_needs')),

                TextColumn::make('status')
                    ->label(__('app.field.status'))
                    ->badge(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListRequests::route('/'),
            // 'create' => Pages\CreateRequest::route('/create'),
            'view' => Pages\ViewRequest::route('/{record}'),
        ];
    }
}
