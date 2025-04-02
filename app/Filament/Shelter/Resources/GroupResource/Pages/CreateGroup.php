<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\GroupResource\Pages;

use App\Filament\Shelter\Resources\GroupResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGroup extends CreateRecord
{
    protected static string $resource = GroupResource::class;
}
