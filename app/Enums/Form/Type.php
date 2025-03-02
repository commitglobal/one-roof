<?php

declare(strict_types=1);

namespace App\Enums\Form;

use App\Enums\Concerns\Arrayable;
use App\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Type: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case PERSONAL = 'personal';
    case REQUEST = 'request';

    public function getLabel(): string
    {
        return match ($this) {
            self::PERSONAL => __('app.form.type.personal'),
            self::REQUEST => __('app.form.type.request'),
        };
    }
}
