<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Schemas;

use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;

class OrganizationInfolist
{
    public static function getSchema(): array
    {
        return [
            TextEntry::make('name')
                ->label(__('app.field.name')),

            TextEntry::make('legal_name')
                ->label(__('app.field.legal_name')),

            TextEntry::make('country.name')
                ->label(__('app.field.country')),

            TextEntry::make('location.name')
                ->label(__('app.field.location')),

            TextEntry::make('address')
                ->label(__('app.field.address'))
                ->columnSpanFull(),

            TextEntry::make('type')
                ->label(__('app.field.organization_type')),

            TextEntry::make('identifier')
                ->label(__('app.field.identifier')),

            Fieldset::make(__('app.field.legal_representative'))
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    TextEntry::make('representative.name')
                        ->label(__('app.field.name')),

                    TextEntry::make('representative.email')
                        ->label(__('app.field.email')),

                    TextEntry::make('representative.phone')
                        ->label(__('app.field.phone')),
                ]),

            Fieldset::make(__('app.field.contact_person'))
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    TextEntry::make('contact.name')
                        ->label(__('app.field.name')),

                    TextEntry::make('contact.email')
                        ->label(__('app.field.email')),

                    TextEntry::make('contact.phone')
                        ->label(__('app.field.phone')),
                ]),

            SpatieMediaLibraryImageEntry::make('documents')
                ->label(__('app.field.legal_documents'))
                ->columnSpanFull(),

            SpatieMediaLibraryImageEntry::make('logo')
                ->label(__('app.field.logo'))
                ->collection('logo')
                ->columnSpanFull(),

            TextEntry::make('notes')
                ->label(__('app.field.notes'))
                ->html()
                ->columnSpanFull(),
        ];
    }
}
