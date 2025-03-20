<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\LogsActivity;
use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;
    use HasTranslations;
    use LogsActivity;
    use SoftDeletes;

    protected static string $factory = LocationFactory::class;

    protected $fillable = [
        'name',
    ];

    public array $translatable = [
        'name',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    public function shelters(): HasMany
    {
        return $this->hasMany(Shelter::class);
    }
}
