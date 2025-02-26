<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

trait DisablesBreadcrumbs
{
    public function getBreadcrumbs(): array
    {
        return [];
    }
}
