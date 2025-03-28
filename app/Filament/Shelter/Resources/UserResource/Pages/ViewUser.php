<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\UserResource\Pages;

use App\Filament\Shelter\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
