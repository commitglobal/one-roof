<?php

declare(strict_types=1);

namespace App\Concerns;

trait HasAttributeStatus
{
    public function isActive(): bool
    {
        return $this->is_enabled;
    }

    public function isInactive(): bool
    {
        return ! $this->isActive();
    }

    public function activate(): bool
    {
        return $this->update([
            'is_enabled' => true,
        ]);
    }

    public function deactivate(): bool
    {
        return $this->update([
            'is_enabled' => false,
        ]);
    }
}
