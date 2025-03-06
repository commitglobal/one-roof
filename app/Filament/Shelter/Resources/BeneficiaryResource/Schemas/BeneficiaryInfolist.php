<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;

class BeneficiaryInfolist
{
    public static function getSchema(): array
    {
        return [
            TextEntry::make('name')
                ->label(__('app.field.name')),

            TextEntry::make('date_of_birth')
                ->label(__('app.field.date_of_birth'))
                ->date(),

            TextEntry::make('gender')
                ->label(__('app.field.gender')),

            TextEntry::make('nationality.name')
                ->label(__('app.field.nationality')),

            TextEntry::make('id_type')
                ->label(__('app.field.id_type')),

            TextEntry::make('id_number')
                ->label(__('app.field.id_number')),

            TextEntry::make('residenceCountry.name')
                ->label(__('app.field.residence_country')),

            TextEntry::make('phone')
                ->label(__('app.field.phone')),

            TextEntry::make('email')
                ->label(__('app.field.email')),

            SpatieMediaLibraryImageEntry::make('photo')
                ->label(__('app.field.photo'))
                ->collection('photo')
                ->columnSpanFull(),

            TextEntry::make('notes')
                ->label(__('app.field.notes'))
                ->columnSpanFull(),
        ];
    }
}
