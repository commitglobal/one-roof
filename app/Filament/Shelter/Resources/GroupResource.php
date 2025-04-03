<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources;

use App\Filament\Shelter\Resources\GroupResource\Pages;
use App\Filament\Shelter\Resources\GroupResource\RelationManagers\StaysRelationManager;
use App\Filament\Shelter\Resources\GroupResource\Schemas\GroupForm;
use App\Filament\Shelter\Resources\GroupResource\Schemas\GroupInfolist;
use App\Models\Group;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    protected static bool $isScopedToTenant = true;

    public static function getNavigationGroup(): ?string
    {
        return __('app.navigation.activity');
    }

    public static function getModelLabel(): string
    {
        return __('app.group.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.group.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(GroupForm::getSchema());
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema(GroupInfolist::getSchema());
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
                    ->label(__('app.field.group_name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('stays_count')
                    ->label(__('app.field.group_members'))
                    ->counts('stays')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StaysRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'view' => Pages\ViewGroup::route('/{record}'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
