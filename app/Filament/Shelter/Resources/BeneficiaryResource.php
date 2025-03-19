<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources;

use App\Enums\Gender;
use App\Filament\Shelter\Resources\BeneficiaryResource\Pages;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\BeneficiaryDynamicForm;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\BeneficiaryDynamicInfolist;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\BeneficiaryForm;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\BeneficiaryInfolist;
use App\Filters\DateFilter;
use App\Models\Beneficiary;
use App\Models\Stay;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    protected static bool $isScopedToTenant = false;

    public static function getNavigationGroup(): ?string
    {
        return __('app.navigation.activity');
    }

    public static function getModelLabel(): string
    {
        return __('app.beneficiary.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.beneficiary.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema(BeneficiaryForm::getSchema()),

                ...BeneficiaryDynamicForm::getSchema(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->columns(3)
                    ->heading(__('app.beneficiary.steps.personal_details'))
                    ->headerActions([
                        Action::make('edit')
                            ->label(__('filament-actions::edit.single.label'))
                            ->url(fn ($record) => static::getUrl('edit', ['record' => $record]))
                            ->icon('heroicon-o-pencil-square')
                            ->color('gray')
                            ->outlined(),
                    ])
                    ->schema(BeneficiaryInfolist::getSchema()),

                ...BeneficiaryDynamicInfolist::getSchema(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $query
                    ->with('latestStay')
                    ->whereRelation('stays', 'shelter_id', Filament::getTenant()->id);
            })
            ->columns([
                TextColumn::make('id')
                    ->label(__('app.field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->shrink(),

                TextColumn::make('created_at')
                    ->label(__('app.field.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->shrink(),

                TextColumn::make('name')
                    ->label(__('app.field.name'))
                    ->sortable()
                    ->searchable()
                    ->shrink(),

                TextColumn::make('latestStay')
                    ->label(__('app.field.latest_stay'))
                    ->formatStateUsing(fn (Stay $state) => \sprintf(
                        '%s – %s',
                        $state->start_date->toFormattedDate(),
                        $state->end_date->toFormattedDate(),
                    )),
            ])
            ->filters([
                SelectFilter::make('gender')
                    ->label(__('app.field.gender'))
                    ->options(Gender::options())
                    ->multiple(),

                SelectFilter::make('nationality')
                    ->relationship('nationality', 'name')
                    ->label(__('app.field.nationality'))
                    ->preload()
                    ->multiple(),

                SelectFilter::make('residenceCountry')
                    ->relationship('residenceCountry', 'name')
                    ->label(__('app.field.residence_country'))
                    ->preload()
                    ->multiple(),

                DateFilter::make('date_of_birth')
                    ->label(__('app.field.date_of_birth')),

                DateFilter::make('created_at')
                    ->label(__('app.field.registration_date')),

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

    public static function getWidgets(): array
    {
        return [
            BeneficiaryResource\Widgets\StaysWidget::class,
            BeneficiaryResource\Widgets\DocumentsWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBeneficiaries::route('/'),
            'create' => Pages\CreateBeneficiary::route('/create'),
            'view' => Pages\ViewBeneficiary::route('/{record}'),
            'edit' => Pages\EditBeneficiary::route('/{record}/edit'),
            'stay' => Pages\ViewStay::route('/{record}/stay/{stay}'),
            'document' => Pages\ViewDocument::route('/{record}/document/{document}'),
        ];
    }
}
