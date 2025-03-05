<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum IDType: string implements HasLabel
{
    use Concerns\Arrayable;
    use Concerns\Comparable;

    case PASSPORT = 'passport';
    case NATIONAL_ID_CARD = 'national_id_card';
    case DRIVERS_LICENSE = 'drivers_license';
    case RESIDENCE_PERMIT = 'residence_permit';
    case OTHER = 'other';
    case NONE = 'none';

    public function getLabel(): string
    {
        return match ($this) {
            self::PASSPORT => __('app.id_type.passport'),
            self::NATIONAL_ID_CARD => __('app.id_type.national_id_card'),
            self::DRIVERS_LICENSE => __('app.id_type.drivers_license'),
            self::RESIDENCE_PERMIT => __('app.id_type.residence_permit'),
            self::OTHER => __('app.id_type.other'),
            self::NONE => __('app.id_type.none'),
        };
    }
}
