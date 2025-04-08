<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasRequestStatus;
use App\Concerns\LogsActivity;
use App\Concerns\Searchable;
use App\Data\GroupMemberData;
use App\Data\PersonData;
use App\Enums\Gender;
use App\Enums\RequestStatus;
use App\Enums\SpecialNeed;
use Database\Factories\RequestFactory;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\LaravelData\DataCollection;

class Request extends Model
{
    /** @use HasFactory<RequestFactory> */
    use HasFactory;
    use HasRequestStatus;
    use LogsActivity;
    use Searchable;

    protected static string $factory = RequestFactory::class;

    protected $fillable = [
        'requester',
        'beneficiary',
        'group',
        'shelter_id',
        'departure_country_id',
        'nationality_id',
        'gender',
        'age',
        'start_date',
        'end_date',
        'special_needs',
        'special_needs_notes',
        'notes',
        'reason_rejected',
        'referral_notes',
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'beneficiary' => PersonData::class,
            'end_date' => 'date',
            'gender' => Gender::class,
            'group_size' => 'integer',
            'group' => DataCollection::class . ':' . GroupMemberData::class . ',default',
            'requester' => PersonData::class,
            'special_needs' => AsEnumCollection::of(SpecialNeed::class),
            'start_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $request) {
            $request->group ??= [];
        });
    }

    public function departureCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'departure_country_id');
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    public function stay(): HasOne
    {
        return $this->hasOne(Stay::class);
    }

    public function referToShelter(Shelter $shelter, ?string $notes = null): void
    {
        $this->update([
            'status' => RequestStatus::REFERRED,
            'shelter_id' => $shelter->id,
            'referral_notes' => $notes,
        ]);
    }

    public function tapActivity(Activity $activity, string $event): void
    {
        if ($event !== 'updated') {
            return;
        }

        $attributes = data_get($activity, 'changes.attributes', []);
        $status = data_get($attributes, 'status', $this->status);

        if (RequestStatus::REFERRED->isNot($status)) {
            return;
        }

        $activity->event = 'referred';
        $activity->description = 'referred';
    }

    public function title(): Attribute
    {
        return Attribute::make(
            fn () => \sprintf(
                '#%s - %s',
                $this->id,
                $this->beneficiary->name,
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
                        'optional' => true,
                    ],
                    [
                        'name' => 'beneficiary_name',
                        'type' => 'string',
                    ],
                ],
            ],
            'search-parameters' => [
                'query_by' => 'searchable_id,beneficiary_name',
            ],
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'searchable_id' => (string) $this->id,
            'shelter_id' => (string) $this->shelter_id,
            'beneficiary_name' => $this->beneficiary->name,
        ];
    }
}
