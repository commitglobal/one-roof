<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasStatus;
use App\Data\PersonData;
use App\Enums\OrganizationType;
use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Organization extends Model implements HasMedia
{
    /** @use HasFactory<OrganizationFactory> */
    use HasFactory;
    use HasStatus;
    use InteractsWithMedia;

    protected static string $factory = OrganizationFactory::class;

    protected $fillable = [
        'name',
        'legal_name',
        'country_id',
        'location_id',
        'address',
        'type',
        'identifier',
        'representative',
        'contact',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'type' => OrganizationType::class,
            'representative' => PersonData::class,
            'contact' => PersonData::class,
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->fit(Fit::Contain, 64, 64)
                    ->keepOriginalImageFormat()
                    ->optimize();

                $this->addMediaConversion('large')
                    ->fit(Fit::Contain, 256, 256)
                    ->keepOriginalImageFormat()
                    ->optimize();
            });
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function shelters(): HasMany
    {
        return $this->hasMany(Shelter::class);
    }

    public function admins(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
