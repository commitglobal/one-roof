<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\GroupResource\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class GroupInfolist
{
    public static function getSchema(): array
    {
        return [
            Section::make()
                ->columns(3)
                ->schema([
                    TextEntry::make('id')
                        ->label(__('app.field.id'))
                        ->prefix('#'),

                    TextEntry::make('name')
                        ->label(__('app.field.group_name')),

                    TextEntry::make('created_at')
                        ->label(__('app.field.created_at'))
                        ->dateTime(),
                ]),
        ];
    }
}
