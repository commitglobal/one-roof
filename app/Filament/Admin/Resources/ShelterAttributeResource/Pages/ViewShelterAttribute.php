<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ShelterAttributeResource\Pages;

use App\Filament\Admin\Resources\ShelterAttributeResource;
use App\Filament\Admin\Resources\ShelterAttributeResource\RelationManagers\ShelterVariablesRelationManager;
use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Concerns\UsesRecordTitle;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShelterAttribute extends ViewRecord
{
    use UsesBreadcrumbFromTitle;
    use UsesRecordTitle;

    protected static string $resource = ShelterAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function getForms(): array
    {
        return [
            // Disables form
            'form' => $this->form($this->makeForm()),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            ShelterVariablesRelationManager::class,
        ];
    }
}
