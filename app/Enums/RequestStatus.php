<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RequestStatus: string implements HasColor, HasLabel
{
    use Concerns\Arrayable;
    use Concerns\Comparable;

    case NEW = 'new';
    case REFERRED = 'referred';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case OBSOLETE = 'obsolete';
    case DUPLICATE = 'duplicate';

    public function getLabel(): string
    {
        return match ($this) {
            self::NEW => __('app.request.status.new'),
            self::REFERRED => __('app.request.status.referred'),
            self::PENDING => __('app.request.status.pending'),
            self::ACCEPTED => __('app.request.status.accepted'),
            self::REJECTED => __('app.request.status.rejected'),
            self::OBSOLETE => __('app.request.status.obsolete'),
            self::DUPLICATE => __('app.request.status.duplicate'),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::NEW => Color::Red,
            self::REFERRED => Color::Blue,
            self::PENDING => Color::Yellow,
            self::ACCEPTED => Color::Green,
            self::REJECTED => Color::Red,
            self::OBSOLETE => Color::Gray,
            self::DUPLICATE => Color::Gray,
        };
    }
}
