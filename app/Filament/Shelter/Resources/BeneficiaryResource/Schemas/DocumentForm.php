<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Enums\DocumentType;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class DocumentForm
{
    public static function getSchema(?int $beneficiary_id = null): array
    {
        return [
            Hidden::make('beneficiary_id')
                ->default($beneficiary_id),

            Select::make('type')
                ->label(__('app.field.document_type'))
                ->options(DocumentType::options())
                ->enum(DocumentType::class)
                ->required(),

            TextInput::make('name')
                ->label(__('app.field.document_name'))
                ->required(),

            Textarea::make('notes')
                ->label(__('app.field.notes'))
                ->maxLength(500)
                ->rows(5),

            SpatieMediaLibraryFileUpload::make('file')
                ->label(__('app.field.upload_document'))
                ->required(),

        ];
    }
}
