<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\LogsActivity;
use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;
    use HasTranslations;
    use LogsActivity;

    protected static string $factory = LocationFactory::class;

    protected $fillable = [
        'name',
    ];

    public array $translatable = [
        'name',
    ];
}
