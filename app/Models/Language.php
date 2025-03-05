<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = 'code';

    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'enabled',
    ];

    protected function casts()
    {
        return [
            'enabled' => 'boolean',
        ];
    }

    public function getNameAttribute(): ?string
    {
        return locale_get_display_name($this->code) ?: null;
    }

    public function getNativeNameAttribute(): ?string
    {
        return locale_get_display_name($this->code, $this->code) ?: null;
    }
}
