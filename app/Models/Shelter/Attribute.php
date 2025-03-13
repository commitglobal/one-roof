<?php

declare(strict_types=1);

namespace App\Models\Shelter;

use App\Enums\AttributeType;
use Database\Factories\Shelter\AttributeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    /** @use HasFactory<AttributeFactory> */
    use HasFactory;
    use HasTranslations;

    protected static string $factory = AttributeFactory::class;

    public $table = 'shelter_attributes';

    protected $fillable = [
        'name',
        'type',
        'is_enabled',
    ];

    public array $translatable = [
        'name',
    ];

    public function casts(): array
    {
        return [
            'type' => AttributeType::class,
            'is_enabled' => 'boolean',
        ];
    }

    public function variables(): HasMany
    {
        return $this->hasMany(Variable::class);
    }

    public function scopeWhereAttribute(Builder $query): Builder
    {
        return $query->where('type', AttributeType::ATTRIBUTE);
    }
}
