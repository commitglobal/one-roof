<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\FormResource\Pages;

use App\Filament\Admin\Resources\FormResource;
use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use Filament\Resources\Pages\CreateRecord;

class CreateForm extends CreateRecord
{
    use UsesBreadcrumbFromTitle;
    // use CreateRecord\Concerns\Translatable;

    protected static string $resource = FormResource::class;
}
