<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOrganization
{
    public function initializeBelongsToOrganization(): void
    {
        $this->fillable[] = 'organization_id';
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
