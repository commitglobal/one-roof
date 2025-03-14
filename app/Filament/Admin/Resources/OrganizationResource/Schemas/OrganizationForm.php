<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Schemas;

use App\Enums\OrganizationType;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class OrganizationForm
{
    public static function getSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('app.field.name'))
                ->required(),

            TextInput::make('legal_name')
                ->label(__('app.field.legal_name'))
                ->required(),

            Select::make('country_id')
                ->relationship('country', 'name')
                ->label(__('app.field.country'))
                ->searchable()
                ->preload()
                ->required(),

            Select::make('location_id')
                ->relationship('location', 'name')
                ->label(__('app.field.location'))
                ->searchable()
                ->preload()
                ->createOptionForm([
                    TextInput::make('name')
                        ->label(__('app.field.name'))
                        ->required(),
                ])
                ->required(),

            TextInput::make('address')
                ->label(__('app.field.address'))
                ->required()
                ->columnSpanFull(),

            Select::make('type')
                ->label(__('app.field.organization_type'))
                ->options(OrganizationType::options())
                ->enum(OrganizationType::class)
                ->nullable(),

            TextInput::make('identifier')
                ->label(__('app.field.identifier'))
                ->nullable(),

            Fieldset::make(__('app.field.legal_representative'))
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    TextInput::make('representative.name')
                        ->label(__('app.field.name'))
                        ->requiredWith(['representative.email', 'representative.phone']),

                    TextInput::make('representative.email')
                        ->label(__('app.field.email'))
                        ->email()
                        ->requiredWith(['representative.name', 'representative.phone']),

                    TextInput::make('representative.phone')
                        ->label(__('app.field.phone'))
                        ->tel()
                        ->requiredWith(['representative.name', 'representative.email']),
                ]),

            Fieldset::make(__('app.field.contact_person'))
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    TextInput::make('contact.name')
                        ->label(__('app.field.name'))
                        ->required(),

                    TextInput::make('contact.email')
                        ->label(__('app.field.email'))
                        ->required()
                        ->email(),

                    TextInput::make('contact.phone')
                        ->label(__('app.field.phone'))
                        ->tel()
                        ->required(),
                ]),

            SpatieMediaLibraryFileUpload::make('documents')
                ->label(__('app.field.legal_documents'))
                ->multiple()
                ->previewable(false)
                ->acceptedFileTypes([
                    'application/pdf',
                    'image/png',
                    'image/jpeg',
                ])
                ->columnSpanFull(),

            SpatieMediaLibraryFileUpload::make('logo')
                ->label(__('app.field.logo'))
                ->collection('logo')
                ->image()
                ->columnSpanFull(),

            Textarea::make('notes')
                ->label(__('app.field.notes'))
                ->rows(5)
                ->columnSpanFull(),
        ];
    }
}
