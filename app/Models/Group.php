<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToShelter;
use App\Concerns\LogsActivity;
use App\Concerns\Searchable;
use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Builder;
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
    // use Searchable;

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
                ],
            ],
            'search-parameters' => [
                'query_by' => 'id',
            ],
        ];
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            // 'stays:id,start_date,end_date,beneficiary_id,group_id',
            'stays.beneficiary:id,name',
        ]);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            // 'stay' => $this->stay,
            // 'beneficiary_id' => (string) $this->stay->beneficiary_id,
            // 'beneficiary_name' => $this->stay->beneficiary->name,
            // 'start_date' => $this->stay->start_date->toFormattedDate(),
            // 'end_date' => $this->stay->end_date->toFormattedDate(),
        ];
    }
}
