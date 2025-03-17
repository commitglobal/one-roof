<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasRequestStatus;
use App\Concerns\LogsActivity;
use App\Data\GroupMemberData;
use App\Data\PersonData;
use App\Enums\Gender;
use App\Enums\RequestStatus;
use App\Enums\SpecialNeed;
use Database\Factories\RequestFactory;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\LaravelData\DataCollection;

class Request extends Model
{
    /** @use HasFactory<RequestFactory> */
    use HasFactory;
    use HasRequestStatus;
    use LogsActivity;

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

    public function referToShelter(Shelter $shelter, ?string $notes = null): void
    {
        activity()->withoutLogs(
            fn () => $this->update([
                'status' => RequestStatus::REFERRED,
                'shelter_id' => $shelter->id,
            ])
        );

        activity()
            ->performedOn($this)
            ->withProperties([
                'shelter' => $shelter->id,
            ])
            ->event('referred')
            ->log($notes ?: 'referred');
    }
}
