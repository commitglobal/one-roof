<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Gender: string implements HasLabel
{
    use Concerns\Arrayable;
    use Concerns\Comparable;

    case WOMAN = 'female';
    case MAN = 'male';
    case TRANS_WOMAN = 'trans_woman';
    case TRANS_MAN = 'trans_man';
    case NONBINARY = 'nonbinary';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::WOMAN => __('app.gender.woman'),
            self::MAN => __('app.gender.man'),
            self::TRANS_WOMAN => __('app.gender.trans_woman'),
            self::TRANS_MAN => __('app.gender.trans_man'),
            self::NONBINARY => __('app.gender.nonbinary'),
            self::OTHER => __('app.gender.other'),
        };
    }
}
