<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\ConfigurationResource\Concerns;

use Filament\Facades\Filament;

trait HasConfigurationMount
{
    public function mount(int | string $record = ''): void
    {
        $this->record = Filament::getTenant();

        $this->authorizeAccess();

        if (! method_exists($this, 'hasInfoList') || ! $this->hasInfolist()) {
            $this->fillForm();
        }
    }
}
