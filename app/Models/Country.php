<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\LogsActivity;
use App\Models\Scopes\OrderbyTranslated;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;
    use LogsActivity;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
    ];

    public array $translatable = [
        'name',
    ];

    public static function booted(): void
    {
        static::addGlobalScope(new OrderbyTranslated('name'));
    }
}
