<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

trait UsesBreadcrumbFromTitle
{
    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }
}
