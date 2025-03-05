<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Gender;
use App\Enums\IDType;
use App\Models\Form\Response;
use Database\Factories\BeneficiaryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Beneficiary extends Model implements HasMedia
{
    /** @use HasFactory<BeneficiaryFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected static string $factory = BeneficiaryFactory::class;

    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'nationality_id',
        'id_type',
        'id_number',
        'residence_country_id',
        'phone',
        'email',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'gender' => Gender::class,
            'id_type' => IDType::class,
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumb')
                    ->fit(Fit::Contain, 64, 64)
                    ->keepOriginalImageFormat()
                    ->optimize();
            });
    }

    public function stays(): HasMany
    {
        return $this->hasMany(Stay::class);
    }

    public function latestStay(): HasOne
    {
        return $this->hasOne(Stay::class)->latestOfMany('end_date');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function personal(): MorphMany
    {
        return $this->morphMany(Response::class, 'model')
            ->with('fields')
            ->latest();
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    public function residenceCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'residence_country_id');
    }
}
