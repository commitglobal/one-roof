<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\RequestResource\Pages;

use App\Filament\Admin\Resources\RequestResource;
use App\Filament\Concerns\DisablesBreadcrumbs;
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
