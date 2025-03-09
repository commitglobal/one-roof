<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToShelter;
use Database\Factories\StayFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stay extends Model
{
    use BelongsToShelter;
    /** @use HasFactory<StayFactory> */
    use HasFactory;

    protected static string $factory = StayFactory::class;

    protected $fillable = [
        'start_date',
        'end_date',
        'beneficiary_id',
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

    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }

    public function hasChildren(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => filled($attributes['children_count']) || filled($attributes['children_notes']),
        );
    }
}
