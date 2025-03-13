<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

trait UsesRecordTitle
{
    public function getTitle(): string
    {
        if (static::getResource()::getRecordTitleAttribute()) {
            return static::getResource()::getRecordTitle($this->getRecord());
        }

        return parent::getTitle();
    }
}
