<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Infolists\Components\DocumentPreview;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class DocumentInfolist
{
    public static function getSchema(): array
    {
        return [
            Section::make()
                ->columns()
                ->schema([
                    TextEntry::make('created_at')
                        ->label(__('app.field.created_at'))
                        ->dateTime(),

                    TextEntry::make('type')
                        ->label(__('app.field.document_type')),

                    TextEntry::make('notes')
                        ->label(__('app.field.notes'))
                        ->columnSpanFull(),
                ]),

            DocumentPreview::make('file')
                ->hiddenLabel()
                ->columnSpanFull(),
        ];
    }
}
