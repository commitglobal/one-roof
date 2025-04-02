<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\GroupResource\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class GroupForm
{
    public static function getSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    TextInput::make('name')
                        ->label(__('app.field.group_name'))
                        ->required(),
                ]),
        ];
    }
}
