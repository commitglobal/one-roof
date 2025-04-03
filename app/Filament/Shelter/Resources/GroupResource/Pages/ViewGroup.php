<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\GroupResource\Pages;

use App\Filament\Shelter\Resources\GroupResource;
use App\Filament\Shelter\Resources\GroupResource\RelationManagers\StaysRelationManager;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGroup extends ViewRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            StaysRelationManager::class,
        ];
    }
}
