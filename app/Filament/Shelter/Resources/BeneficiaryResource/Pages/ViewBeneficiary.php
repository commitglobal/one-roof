<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Shelter\Resources\BeneficiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBeneficiary extends ViewRecord
{
    use UsesBreadcrumbFromTitle;

    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return \sprintf('#%s %s', $this->record->id, $this->record->name);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BeneficiaryResource\Widgets\StaysWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            BeneficiaryResource\Widgets\DocumentsWidget::class,
        ];
    }
}
