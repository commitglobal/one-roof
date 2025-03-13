<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\ConfigurationResource\Pages;

use App\Filament\Concerns\DisablesBreadcrumbs;
use App\Filament\Shelter\Resources\ConfigurationResource;
use App\Filament\Shelter\Resources\ConfigurationResource\Concerns\HasConfigurationMount;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditAttributes extends EditRecord
{
    use DisablesBreadcrumbs;
    use HasConfigurationMount;

    protected static string $resource = ConfigurationResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index', [
            'tab' => '-attributes-tab',
        ]);
    }
}
