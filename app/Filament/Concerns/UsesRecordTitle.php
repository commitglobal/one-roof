<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

trait UsesRecordTitle
{
    public function getTitle(): string
    {
        $title = static::getResource()::getRecordTitleAttribute();

        if (filled($title)) {
            return $title;
        }

        return parent::getTitle();
    }
}
