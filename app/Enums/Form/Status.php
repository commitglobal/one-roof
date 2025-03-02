<?php

declare(strict_types=1);

namespace App\Enums\Form;

use App\Enums\Concerns\Arrayable;
use App\Enums\Concerns\Comparable;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    use Arrayable;
    use Comparable;

    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case OBSOLETE = 'obsolete';

    public function getLabel(): string
    {
        return match ($this) {
            self::DRAFT => __('app.form.status.draft'),
            self::PUBLISHED => __('app.form.status.published'),
            self::OBSOLETE => __('app.form.status.obsolete'),
        };
    }

    public function getColor(): array
    {
        return match ($this) {
            self::DRAFT => Color::Yellow,
            self::PUBLISHED => Color::Green,
            self::OBSOLETE => Color::Gray,
        };
    }
}
