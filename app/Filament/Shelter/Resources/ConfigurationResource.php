<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources;

use App\Filament\Shelter\Resources\ConfigurationResource\Pages;
use App\Models\Shelter;
use Filament\Resources\Resource;

class ConfigurationResource extends Resource
{
    protected static ?string $model = Shelter::class;

    protected static ?string $navigationIcon = 'heroicon-s-cog-6-tooth';

    public static function getNavigationGroup(): ?string
    {
        return __('app.navigation.configurations');
    }

    public static function getModelLabel(): string
    {
        return __('app.navigation.shelter_configuration');
    }

    public static function getPluralModelLabel(): string
    {
        return static::getModelLabel();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ViewConfiguration::route('/'),
            'profile' => Pages\EditProfile::route('/profile'),
            'attributes' => Pages\EditAttributes::route('/attributes'),
            // 'facilities' => Pages\EditFacilities::route('/facilities'),
        ];
    }
}
