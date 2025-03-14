<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\ConfigurationResource\Pages;

use App\Filament\Concerns\DisablesBreadcrumbs;
use App\Filament\Shelter\Resources\ConfigurationResource;
use App\Filament\Shelter\Resources\ConfigurationResource\Concerns\HasConfigurationMount;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditProfile extends EditRecord
{
    use DisablesBreadcrumbs;
    use HasConfigurationMount;

    protected static string $resource = ConfigurationResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('app.shelter.profile'))
                    ->columns()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('app.field.name'))
                            ->required(),

                        TextInput::make('capacity')
                            ->label(__('app.field.capacity'))
                            ->integer()
                            ->minValue(0)
                            ->maxValue(10_000_000)
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

                        Fieldset::make(__('app.field.shelter_coordinator'))
                            ->columns(3)
                            ->schema([
                                TextInput::make('coordinator.name')
                                    ->label(__('app.field.name'))
                                    ->required(),

                                TextInput::make('coordinator.email')
                                    ->label(__('app.field.email'))
                                    ->email()
                                    ->required(),

                                TextInput::make('coordinator.phone')
                                    ->label(__('app.field.phone'))
                                    ->tel()
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index', [
            'tab' => '-profile-tab',
        ]);
    }
}
