<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Enums\Gender;
use App\Enums\IDType;
use App\Models\Country;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BeneficiaryForm
{
    public static function getSchema(): array
    {
        $countries = Country::pluck('name', 'id');

        return [
            TextInput::make('name')
                ->label(__('app.field.name'))
                ->maxLength(200)
                ->required(),

            DatePicker::make('date_of_birth')
                ->label(__('app.field.date_of_birth'))
                ->beforeOrEqual('today')
                ->required(),

            Select::make('gender')
                ->label(__('app.field.gender'))
                ->options(Gender::options())
                ->required(),

            Select::make('nationality_id')
                ->label(__('app.field.nationality'))
                ->options($countries)
                ->searchable()
                ->required(),

            Select::make('id_type')
                ->label(__('app.field.id_type'))
                ->options(IDType::options()),

            TextInput::make('id_number')
                ->label(__('app.field.id_number'))
                ->maxLength(50),

            Select::make('residence_country_id')
                ->label(__('app.field.residence_country'))
                ->options($countries)
                ->searchable(),

            TextInput::make('phone')
                ->label(__('app.field.phone'))
                ->tel()
                ->required(),

            TextInput::make('email')
                ->label(__('app.field.email'))
                ->email(),

            SpatieMediaLibraryFileUpload::make('photo')
                ->label(__('app.field.photo'))
                ->collection('photo')
                ->image()
                ->columnSpanFull(),

            Textarea::make('notes')
                ->label(__('app.field.notes'))
                ->rows(5)
                ->columnSpanFull(),
        ];
    }
}
