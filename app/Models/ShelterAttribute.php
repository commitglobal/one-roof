<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasAttributeStatus;
use App\Enums\AttributeType;
use Database\Factories\ShelterAttributeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class ShelterAttribute extends Model
{
    use HasAttributeStatus;
    /** @use HasFactory<ShelterAttributeFactory> */
    use HasFactory;
    use HasTranslations;

    protected static string $factory = ShelterAttributeFactory::class;

    protected $fillable = [
        'name',
        'type',
        'is_enabled',
        'is_listed',
    ];

    public array $translatable = [
        'name',
    ];

    public function casts(): array
    {
        return [
            'type' => AttributeType::class,
            'is_enabled' => 'boolean',
            'is_listed' => 'boolean',
        ];
    }

    public static function booted(): void
    {
        static::creating(function (self $shelterAttribute) {
            if (blank($shelterAttribute->type)) {
                $shelterAttribute->type = AttributeType::ATTRIBUTE;
            }
        });
    }

    public function shelterVariables(): HasMany
    {
        return $this->hasMany(ShelterVariable::class);
    }

    public function scopeWhereAttribute(Builder $query): Builder
    {
        return $query->where('type', AttributeType::ATTRIBUTE);
    }

    public function scopeWhereListed(Builder $query): Builder
    {
        return $query
            ->where('is_enabled', true)
            ->where('is_listed', true);
    }
}
