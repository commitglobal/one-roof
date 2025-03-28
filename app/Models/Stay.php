<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToShelter;
use App\Concerns\LogsActivity;
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
            ->whereDate('end_date', '>=', today());
    }

    public function scopeWhereInShelter(Builder $query, Shelter $shelter): Builder
    {
        return $query->where('shelter_id', $shelter->id);
    }

    public function hasChildren(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => filled($attributes['children_count']) || filled($attributes['children_notes']),
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
                '#%s %s–%s',
                $this->id,
                $this->start_date->toFormattedDate(),
                $this->end_date->toFormattedDate()
            )
        );
    }
}
