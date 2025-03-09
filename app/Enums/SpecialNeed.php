<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SpecialNeed: string implements HasLabel
{
    use Concerns\Arrayable;
    use Concerns\Comparable;

    // Disabilities, Chronic illness, Paliative care needs, Other
    case DISABILITIES = 'disabilities';
    case CHRONIC_ILLNESS = 'chronic_illness';
    case PALIATIVE_CARE = 'paliative_care';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DISABILITIES => __('app.special_needs.disabilities'),
            self::CHRONIC_ILLNESS => __('app.special_needs.chronic_illness'),
            self::PALIATIVE_CARE => __('app.special_needs.paliative_care'),
            self::OTHER => __('app.special_needs.other'),
        };
    }
}
