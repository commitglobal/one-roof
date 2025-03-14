<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ShelterAttributeResource\Pages;

use App\Filament\Admin\Resources\ShelterAttributeResource;
use App\Filament\Admin\Resources\ShelterAttributeResource\Actions\ActivateAction;
use App\Filament\Admin\Resources\ShelterAttributeResource\Actions\DeactivateAction;
use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Concerns\UsesRecordTitle;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShelterAttribute extends EditRecord
{
    use UsesBreadcrumbFromTitle;
    use UsesRecordTitle;

    protected static string $resource = ShelterAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActivateAction::make(),
            DeactivateAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
