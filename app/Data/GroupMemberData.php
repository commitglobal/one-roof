<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class GroupMemberData extends Data
{
    public function __construct(
        public ?string $name,
        public ?int $age,
        public ?string $notes
    ) {
        //
    }
}
