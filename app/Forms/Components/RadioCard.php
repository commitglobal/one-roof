<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Radio;

class RadioCard extends Radio
{
    protected string $view = 'forms.components.radio-card';

    protected string | Closure | null $gridDirection = 'row';
}
