<?php

declare(strict_types=1);

namespace App\Models\Shelter;

use App\Models\Shelter;
use Database\Factories\Shelter\VariableFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Variable extends Model
{
    /** @use HasFactory<VariableFactory> */
    use HasFactory;
    use HasTranslations;

    protected static string $factory = VariableFactory::class;

    public $table = 'shelter_variables';

    protected $fillable = [
        'name',
        'is_enabled',
        'order',
    ];

    public array $translatable = [
        'name',
    ];

    public function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function shelters(): BelongsToMany
    {
        return $this->belongsToMany(Shelter::class, 'shelter_shelter_variable');
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
