<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\FormResource\Pages;

use App\Filament\Admin\Resources\FormResource;
use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForm extends EditRecord
{
    use UsesBreadcrumbFromTitle;
    // use EditRecord\Concerns\Translatable;

    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            // Actions\LocaleSwitcher::make(),
        ];
    }
}
