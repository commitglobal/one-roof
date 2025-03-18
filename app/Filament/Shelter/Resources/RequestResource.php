<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources;

use App\Enums\RequestStatus;
use App\Filament\Shelter\Resources\RequestResource\Pages;
use App\Filament\Shelter\Resources\RequestResource\Schemas\RequestInfolist;
use App\Models\Request;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $recordTitleAttribute = 'id';

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

    public static function getRecordTitle(?Model $record): string
    {
        return \sprintf(
            '%s #%s',
            Str::ucfirst(__('app.request.label.singular')),
            $record->id
        );
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
                SelectFilter::make('status')
                    ->label(__('app.field.status'))
                    ->options(RequestStatus::options()),
            ], FiltersLayout::AboveContent)
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
            'view' => Pages\ViewRequest::route('/{record}'),
            'refer' => Pages\ReferRequest::route('/{record}/refer'),
        ];
    }
}
