<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Shelter\Resources\BeneficiaryResource;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ListPersonalDataVersions extends ViewRecord
{
    use UsesBreadcrumbFromTitle;

    protected static string $resource = BeneficiaryResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless($this->getRecord()->hasMoreThanOneForm(), 404);
    }

    protected function fillForm(): void
    {
        //
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist;
    }

    protected function getForms(): array
    {
        return [
            // Disables form
            'form' => $this->makeForm(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BeneficiaryResource\Widgets\PersonalDataVersionsWidget::class,
        ];
    }
}
