<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum OrganizationType: string implements HasLabel
{
    use Concerns\Arrayable;
    use Concerns\Comparable;

    case INGO = 'ingo';
    case NGO = 'ngo';
    case PUBLIC = 'public';

    public function getLabel(): string
    {
        return match ($this) {
            self::INGO => __('app.organization.type.ingo'),
            self::NGO => __('app.organization.type.ngo'),
            self::PUBLIC => __('app.organization.type.public'),
        };
    }
}
