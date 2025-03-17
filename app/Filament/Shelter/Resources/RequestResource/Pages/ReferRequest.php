<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\RequestResource\Pages;

use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Concerns\UsesRecordTitle;
use App\Filament\Shelter\Resources\RequestResource;
use Filament\Resources\Pages\ViewRecord;

class ReferRequest extends ViewRecord
{
    use UsesBreadcrumbFromTitle;
    // use UsesRecordTitle;

    protected static string $resource = RequestResource::class;

    public function getTitle(): string
    {
        return \sprintf(
            '%s #%s',
            __('app.request.label.singular'),
            $this->record->id
        );
    }

    protected function getFooterWidgets(): array
    {
        return [
            RequestResource\Widgets\ReferToShelterWidget::class,
        ];
    }
}
