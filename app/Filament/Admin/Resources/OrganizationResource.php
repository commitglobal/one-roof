<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Enums\Status;
use App\Filament\Admin\Resources\OrganizationResource\Pages;
use App\Filament\Admin\Resources\OrganizationResource\Schemas\OrganizationForm;
use App\Filament\Admin\Resources\OrganizationResource\Schemas\OrganizationInfolist;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return __('app.navigation.activity');
    }

    public static function getModelLabel(): string
    {
        return __('app.organization.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.organization.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema(OrganizationForm::getSchema()),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->columns(2)
                    ->heading(__('app.organization.steps.details'))
                    ->headerActions([
                        Action::make('edit')
                            ->label(__('filament-actions::edit.single.label'))
                            ->url(fn ($record) => static::getUrl('edit', ['record' => $record]))
                            ->icon('heroicon-o-pencil-square')
                            ->color('gray')
                            ->outlined(),
                    ])
                    ->schema(OrganizationInfolist::getSchema()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('app.field.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('country.name')
                    ->label(__('app.field.country'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('location.name')
                    ->label(__('app.field.location'))
                    ->searchable()
                    ->sortable(),

                // TextColumn::make('shelters_count')
                //     ->label(__('app.field.shelters'))
                //     ->counts('shelters'),

                // TextColumn::make('beneficiaries_count')
                //     ->label(__('app.field.beneficiaries'))
                //     ->counts('beneficiaries'),

                TextColumn::make('status')
                    ->label(__('app.field.status'))
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('app.field.status'))
                    ->options(Status::options()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'view' => Pages\ViewOrganization::route('/{record}'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
