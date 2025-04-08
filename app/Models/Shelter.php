<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Concerns\LogsActivity;
use App\Data\PersonData;
use Database\Factories\ShelterFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shelter extends Model
{
    use BelongsToOrganization;
    /** @use HasFactory<ShelterFactory> */
    use HasFactory;
    use LogsActivity;

    protected static string $factory = ShelterFactory::class;

    protected $fillable = [
        'name',
        'capacity',
        'country_id',
        'location_id',
        'address',
        'coordinator',
        'notes',
        'is_listed',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'coordinator' => PersonData::class,
            'is_listed' => 'boolean',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Membership::class)
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    public function stays(): HasMany
    {
        return $this->hasMany(Stay::class);
    }

    public function shelterVariables(): BelongsToMany
    {
        return $this->belongsToMany(ShelterVariable::class);
    }

    public function scopeWhereListed(Builder $query): Builder
    {
        return $query
            ->where('is_listed', true)
            ->whereHas('organization', function (Builder $query) {
                $query->whereActive();
            });
    }

    public function scopeWhereHasShelterVariables(Builder $query, array $variables): Builder
    {
        $variables = collect($variables)
            ->filter(fn (array $value) => filled($value));

        if ($variables->isEmpty()) {
            return $query;
        }

        return $query
            ->whereHas('shelterVariables', function (Builder $query) use ($variables) {
                $variables->each(fn (array $values) => $query->whereIn('shelter_variables.id', $values));
            });
    }

    public function availableCapacity(): Attribute
    {
        return Attribute::make(
            fn (mixed $value, array $attributes) => $attributes['capacity'] - $this->stays()
                ->whereDate('end_date', '>', today())
                ->count(),
        );
    }

    public function isListed(): bool
    {
        return $this->is_listed;
    }

    public function isUnlisted(): bool
    {
        return ! $this->isListed();
    }

    public function list(): bool
    {
        return $this->update([
            'is_listed' => true,
        ]);
    }

    public function unlist(): bool
    {
        return $this->update([
            'is_listed' => false,
        ]);
    }
}
