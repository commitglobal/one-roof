<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToShelter;
use App\Concerns\LogsActivity;
use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use BelongsToShelter;
    /** @use HasFactory<GroupFactory> */
    use HasFactory;
    use LogsActivity;

    protected static string $factory = GroupFactory::class;

    protected $fillable = [
        'name',
    ];

    public function stays(): HasMany
    {
        return $this->hasMany(Stay::class);
    }

    public function title(): Attribute
    {
        return Attribute::make(
            fn () => \sprintf('#%d: %s', $this->id, $this->name)
        );
    }
}
