<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Models\Stay;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\TextEntry;

class StayInfolist
{
    public static function getSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    TextEntry::make('start_date')
                        ->label(__('app.field.start_date'))
                        ->date(),

                    TextEntry::make('end_date')
                        ->label(__('app.field.end_date'))
                        ->date(),

                    TextEntry::make('has_children')
                        ->label(__('app.field.has_children'))
                        ->visible(fn (Stay $record) => ! $record->has_children)
                        ->state(__('app.no')),

                    Group::make()
                        ->visible(fn (Stay $record) => $record->has_children)
                        ->columnSpanFull()
                        ->schema([
                            TextEntry::make('children_count')
                                ->label(__('app.field.children_count'))
                                ->numeric(),

                            TextEntry::make('children_notes')
                                ->label(__('app.field.children_notes')),
                        ]),

                ]),
        ];
    }
}
