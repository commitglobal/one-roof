<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\GroupResource\Pages;

use App\Filament\Concerns\DisablesBreadcrumbs;
use App\Filament\Shelter\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroups extends ListRecords
{
    use DisablesBreadcrumbs;

    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
