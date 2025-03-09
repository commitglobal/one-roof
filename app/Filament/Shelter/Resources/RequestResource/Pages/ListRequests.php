<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\RequestResource\Pages;

use App\Filament\Concerns\DisablesBreadcrumbs;
use App\Filament\Shelter\Resources\RequestResource;
use Filament\Resources\Pages\ListRecords;

class ListRequests extends ListRecords
{
    use DisablesBreadcrumbs;

    protected static string $resource = RequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
