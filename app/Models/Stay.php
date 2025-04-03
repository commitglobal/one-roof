<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToShelter;
use App\Concerns\LogsActivity;
use App\Concerns\Searchable;
use Database\Factories\StayFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stay extends Model
{
    use BelongsToShelter;
    /** @use HasFactory<StayFactory> */
    use HasFactory;
    use LogsActivity;
    use Searchable;

    protected static string $factory = StayFactory::class;

    protected $fillable = [
        'start_date',
        'end_date',
        'beneficiary_id',
        'request_id',
        'children_count',
        'children_notes',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }

    public function scopeWhereCurrent(Builder $query): Builder
    {
        return $query
            ->whereDate('start_date', '<=', today())
            ->where(function (Builder $query) {
                $query->whereDate('end_date', '>=', today())
                    ->orWhereNull('end_date');
            });
    }

    public function scopeWhereInShelter(Builder $query, Shelter $shelter): Builder
    {
        return $query->where('shelter_id', $shelter->id);
    }

    protected function isIndefinite(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => blank($attributes['end_date']),
        );
    }

    public function hasChildren(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => filled($attributes['children_count']) || filled($attributes['children_notes']),
        );
    }

    public function hasGroup(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => filled($attributes['group_id']),
        );
    }

    public function hasRequest(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => filled($attributes['request_id']),
        );
    }

    public function title(): Attribute
    {
        return Attribute::make(
            fn () => \sprintf(
                '#%s %s - %s',
                $this->id,
                $this->start_date->toFormattedDate(),
                $this->end_date?->toFormattedDate() ?? __('app.stay.indefinite')
            )
        );
    }

    public function titleWithBeneficiaryName(): Attribute
    {
        return Attribute::make(
            fn () => \sprintf(
                '#%s %s %s - %s',
                $this->id,
                $this->beneficiary->name,
                $this->start_date->toFormattedDate(),
                $this->end_date?->toFormattedDate() ?? __('app.stay.indefinite')
            )
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
                        'name' => 'beneficiary_id',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'beneficiary_name',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'start_date',
                        'type' => 'string',
                    ],
                    [
                        'name' => 'end_date',
                        'type' => 'string',
                    ],
                ],
            ],
            'search-parameters' => [
                'query_by' => 'searchable_id,beneficiary_id,beneficiary_name,start_date,end_date',
            ],
        ];
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            'beneficiary:id,name',
            'group',
        ]);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'searchable_id' => (string) $this->id,
            'shelter_id' => (string) $this->shelter_id,
            'beneficiary_id' => (string) $this->beneficiary_id,
            'beneficiary_name' => $this->beneficiary->name,
            'start_date' => $this->start_date->toFormattedDate(),
            'end_date' => $this->end_date?->toFormattedDate() ??
                locales()
                    ->map(fn (Language $language) => __('app.stay.indefinite', locale: $language->code))
                    ->unique()
                    ->join(', '),
        ];
    }
}
