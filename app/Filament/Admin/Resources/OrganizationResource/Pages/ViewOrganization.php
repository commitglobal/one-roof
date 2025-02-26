<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Pages;

use App\Filament\Admin\Resources\OrganizationResource;
use App\Filament\Admin\Resources\OrganizationResource\Actions\ActivateOrganizationAction;
use App\Filament\Admin\Resources\OrganizationResource\Actions\DeactivateOrganizationAction;
use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use Filament\Resources\Pages\ViewRecord;

class ViewOrganization extends ViewRecord
{
    use UsesBreadcrumbFromTitle;

    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActivateOrganizationAction::make(),
            DeactivateOrganizationAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    public function getContentTabLabel(): ?string
    {
        return __('app.organization.steps.details');
    }
}
