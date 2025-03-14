<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AttributeType: string implements HasLabel
{
    use Concerns\Arrayable;
    use Concerns\Comparable;

    case ATTRIBUTE = 'attribute';
    case FACILITY = 'facility';
    case SERVICE = 'service';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ATTRIBUTE => __('app.attribute.type.attribute'),
            self::FACILITY => __('app.attribute.type.facility'),
            self::SERVICE => __('app.attribute.type.service'),
        };
    }
}
