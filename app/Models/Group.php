<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToShelter;
use App\Concerns\LogsActivity;
use App\Concerns\Searchable;
use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use BelongsToShelter;
    /** @use HasFactory<GroupFactory> */
    use HasFactory;
    use LogsActivity;
    use Searchable;

    protected static string $factory = GroupFactory::class;

    protected $fillable = [
        'name',
    ];

    public function stays(): HasMany
    {
        return $this->hasMany(Stay::class);
    }

    public function title(): Attribute
    {
        return Attribute::make(
            fn () => \sprintf('#%d: %s', $this->id, $this->name)
        );
    }

    public static function typesenseModelSettings(): array
    {
        return [
            'collection-schema' => [
                'fields' => [
                    [
                        'name' => 'id',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'searchable_id',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'shelter_id',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'name',
                        'type' => 'string',
                    ],
                ],
            ],
            'search-parameters' => [
                'query_by' => 'searchable_id,name',
            ],
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'searchable_id' => (string) $this->id,
            'shelter_id' => (string) $this->shelter_id,
            'name' => $this->name,
        ];
    }
}
