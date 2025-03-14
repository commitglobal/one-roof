<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Pages;

use App\Events\OrganizationCreated;
use App\Filament\Admin\Resources\OrganizationResource;
use App\Filament\Admin\Resources\OrganizationResource\Schemas\AdminsForm;
use App\Filament\Admin\Resources\OrganizationResource\Schemas\OrganizationForm;
use App\Filament\Admin\Resources\OrganizationResource\Schemas\SheltersForm;
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

            Step::make(__('app.organization.steps.shelters.title'))
                ->schema(SheltersForm::getSchema()),

            Step::make(__('app.organization.steps.admins.title'))
                ->schema(AdminsForm::getSchema()),
        ];
    }

    protected function afterCreate(): void
    {
        OrganizationCreated::dispatch($this->getRecord());

        // TODO: notify new admins
    }
}
