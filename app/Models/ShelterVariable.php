<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ShelterVariableFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class ShelterVariable extends Model
{
    /** @use HasFactory<ShelterVariableFactory> */
    use HasFactory;
    use HasTranslations;

    protected static string $factory = ShelterVariableFactory::class;

    protected $fillable = [
        'name',
        'is_enabled',
        'order',
    ];

    public array $translatable = [
        'name',
    ];

    public function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function shelters(): BelongsToMany
    {
        return $this->belongsToMany(Shelter::class);
    }

    public function shelterAttribute(): BelongsTo
    {
        return $this->belongsTo(ShelterAttribute::class);
    }
}
