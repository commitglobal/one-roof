<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    use Concerns\Arrayable;
    use Concerns\Comparable;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => __('app.status.active'),
            self::INACTIVE => __('app.status.inactive'),
            self::PENDING => __('app.status.pending'),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::ACTIVE => Color::Green,
            self::INACTIVE => Color::Red,
            self::PENDING => Color::Yellow,
        };
    }
}
