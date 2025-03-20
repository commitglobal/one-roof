<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Models\Request;
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
use Illuminate\Support\Str;

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

                    DatePicker::make('end_date')
                        ->label(__('app.field.end_date'))
                        ->afterOrEqual('start_date')
                        ->required(),

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
                        ->getSearchResultsUsing(
                            fn (string $search) => Request::query()
                                ->whereAllocatable()
                                ->where('shelter_id', Filament::getTenant()->getKey())
                                ->where(function ($query) use ($search) {
                                    $query->whereLike('id', Str::remove('#', $search) . '%')
                                        ->orWhereLike('beneficiary->name', "%{$search}%");
                                })
                                ->get()
                                ->pluck('optionLabel', 'id')
                        )
                        ->getOptionLabelUsing(fn ($value) => Request::find($value)->optionLabel()),

                ]),
        ];
    }
}
