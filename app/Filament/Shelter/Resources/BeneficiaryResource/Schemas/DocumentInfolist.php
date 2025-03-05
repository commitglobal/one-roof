<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;

class DocumentInfolist
{
    public static function getSchema(): array
    {
        return [

            TextEntry::make('type')
                ->label(__('app.field.document_type')),

            TextEntry::make('name')
                ->label(__('app.field.document_name')),

            TextEntry::make('notes')
                ->label(__('app.field.notes')),

            SpatieMediaLibraryImageEntry::make('file')
                ->label(__('app.field.document')),

        ];
    }
}
