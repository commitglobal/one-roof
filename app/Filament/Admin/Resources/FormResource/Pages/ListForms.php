<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\FormResource\Pages;

use App\Filament\Admin\Resources\FormResource;
use App\Filament\Concerns\DisablesBreadcrumbs;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListForms extends ListRecords
{
    use DisablesBreadcrumbs;
    use ListRecords\Concerns\Translatable;

    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
