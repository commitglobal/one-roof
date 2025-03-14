<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ShelterAttributeResource\Pages;

use App\Filament\Admin\Resources\ShelterAttributeResource;
use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use Filament\Resources\Pages\CreateRecord;

class CreateShelterAttribute extends CreateRecord
{
    use UsesBreadcrumbFromTitle;

    protected static string $resource = ShelterAttributeResource::class;
}
