<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Models\Group as GroupModel;
use App\Models\Request;
use App\Models\Shelter;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;

class StayForm
{
    public static function getSchema(?int $beneficiary_id = null): array
    {
        return [
            Grid::make()
                ->schema([
                    Hidden::make('beneficiary_id')
                        ->visible(filled($beneficiary_id))
                        ->default($beneficiary_id),

                    DatePicker::make('start_date')
                        ->label(__('app.field.start_date'))
                        ->required(),

                    static::getEndDateGroup(),

                    Checkbox::make('has_children')
                        ->label(__('app.field.has_children'))
                        ->columnSpanFull()
                        ->live(),

                    Group::make()
                        ->visible(fn (Get $get) => $get('has_children'))
                        ->columnSpanFull()
                        ->schema([
                            TextInput::make('children_count')
                                ->label(__('app.field.children_count'))
                                ->integer()
                                ->minValue(1)
                                ->maxValue(99)
                                ->required(),

                            Textarea::make('children_notes')
                                ->label(__('app.field.children_notes'))
                                ->maxLength(500)
                                ->rows(5),
                        ]),

                    Checkbox::make('has_group')
                        ->label(__('app.field.has_group'))
                        ->columnSpanFull()
                        ->live(),

                    Select::make('group_id')
                        ->label(__('app.field.group'))
                        ->visible(fn (Get $get) => $get('has_group'))
                        ->columnSpanFull()
                        ->searchable()
                        ->preload()
                        ->required()
                        ->getSearchResultsUsing(fn (string $search) => static::getGroupOptions(Filament::getTenant(), $search))
                        ->options(fn () => static::getGroupOptions(Filament::getTenant())),

                    Checkbox::make('has_request')
                        ->label(__('app.field.has_request'))
                        ->columnSpanFull()
                        ->live(),

                    Select::make('request_id')
                        ->label(__('app.field.request'))
                        ->visible(fn (Get $get) => $get('has_request'))
                        ->columnSpanFull()
                        ->searchable()
                        ->preload()
                        ->required()
                        ->getSearchResultsUsing(fn (string $search) => static::getRequestOptions(Filament::getTenant(), $search))
                        ->options(fn () => static::getRequestOptions(Filament::getTenant())),
                ]),
        ];
    }

    public static function getEndDateGroup(): Group
    {
        return Group::make()
            ->schema([
                DatePicker::make('end_date')
                    ->label(__('app.field.end_date'))
                    ->afterOrEqual('start_date')
                    ->required(fn (Get $get) => ! $get('is_indefinite'))
                    ->disabled(fn (Get $get) => $get('is_indefinite')),

                Checkbox::make('is_indefinite')
                    ->label(__('app.field.is_indefinite'))
                    ->live()
                    ->afterStateUpdated(function (bool $state, Set $set) {
                        if ($state) {
                            $set('end_date', null);
                        }
                    }),
            ]);
    }

    protected static function getGroupOptions(Shelter $shelter, ?string $search = null): array
    {
        if (filled($search)) {
            $options = GroupModel::search($search)
                ->query(
                    fn (Builder $query) => $query
                        ->whereBelongsTo($shelter)
                        ->limit(50)
                )
                ->where('shelter_id', $shelter->id)
                ->get();
        } else {
            $options = GroupModel::query()
                ->whereBelongsTo($shelter)
                ->limit(50)
                ->get();
        }

        return $options
            ->pluck('title', 'id')
            ->all();
    }

    protected static function getRequestOptions(Shelter $shelter, ?string $search = null): array
    {
        if (filled($search)) {
            $options = Request::search($search)
                ->query(
                    fn (Builder $query) => $query
                        ->whereBelongsTo($shelter)
                        ->limit(50)
                )
                ->where('shelter_id', $shelter->id)
                ->get();
        } else {
            $options = Request::query()
                ->whereBelongsTo($shelter)
                ->limit(50)
                ->get();
        }

        return $options
            ->pluck('title', 'id')
            ->all();
    }
}
