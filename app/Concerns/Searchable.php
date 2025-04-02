<?php

declare(strict_types=1);

namespace App\Concerns;

use Laravel\Scout\Searchable as ScoutSearchable;

trait Searchable
{
    use ScoutSearchable;

    abstract public static function typesenseModelSettings(): array;
}
