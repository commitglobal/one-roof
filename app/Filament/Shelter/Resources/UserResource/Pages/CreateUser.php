<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\UserResource\Pages;

use App\Filament\Shelter\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
