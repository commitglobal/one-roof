<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel
{
    use Concerns\Arrayable;
    use Concerns\Comparable;

    case FEMALE = 'female';
    case MALE = 'male';
    case NONBINARY = 'nonbinary';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FEMALE => __('app.gender.female'),
            self::MALE => __('app.gender.male'),
            self::NONBINARY => __('app.gender.nonbinary'),
            self::OTHER => __('app.gender.other'),
        };
    }
}
