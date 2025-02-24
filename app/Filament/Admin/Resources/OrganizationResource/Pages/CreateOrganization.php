<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Pages;

use App\Filament\Admin\Resources\OrganizationResource;
use App\Filament\Admin\Resources\OrganizationResource\Schemas\OrganizationForm;
use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\Concerns\HasWizard;
use Filament\Resources\Pages\CreateRecord;

class CreateOrganization extends CreateRecord
{
    use HasWizard;
    use UsesBreadcrumbFromTitle;

    protected static string $resource = OrganizationResource::class;

    public function getSteps(): array
    {
        return [
            Step::make(__('app.organization.steps.details'))
                ->columns(2)
                ->schema(OrganizationForm::getSchema()),

            Step::make(__('app.organization.steps.shelters'))
                ->schema([
                    // TODO: add shelters form schema
                ]),

            Step::make(__('app.organization.steps.admins'))
                ->schema([
                    // TODO: add admins form schema
                ]),
        ];
    }
}
