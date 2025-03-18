<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Filament\Concerns\DisablesBreadcrumbs;
use App\Filament\Shelter\Resources\BeneficiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBeneficiaries extends ListRecords
{
    use DisablesBreadcrumbs;

    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BeneficiaryResource\Widgets\BeneficiariesStatsWidget::class,
        ];
    }
}
