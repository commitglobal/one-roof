<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Scopes\BelongsToCurrentTenant;
use App\Models\Shelter;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToShelter
{
    public function initializeBelongsToShelter(): void
    {
        $this->fillable[] = 'shelter_id';
    }

    protected static function bootBelongsToShelter(): void
    {
        static::creating(function (self $model) {
            if (! Filament::auth()->check()) {
                return;
            }

            if (! Filament::hasTenancy()) {
                return;
            }

            $model->shelter_id = Filament::getTenant()->id;
        });

        // TODO: clarify if we need this
        // static::addGlobalScope(new BelongsToCurrentTenant);
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }
}
