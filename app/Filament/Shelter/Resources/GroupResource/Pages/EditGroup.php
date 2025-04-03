<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\GroupResource\Pages;

use App\Filament\Shelter\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
