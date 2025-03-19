<?php

declare(strict_types=1);

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldResponse extends Model
{
    public $timestamps = false;

    protected $table = 'form_field_responses';

    protected $fillable = [
        'response_id',
        'field_id',
        'value',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'json',
        ];
    }

    public function response(): BelongsTo
    {
        return $this->belongsTo(Response::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}
