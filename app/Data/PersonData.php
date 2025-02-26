<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class PersonData extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $email,
        public ?string $phone
    ) {
        //
    }
}
