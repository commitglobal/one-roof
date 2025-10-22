<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as Page;

class Dashboard extends Page
{
    public function getColumns(): int | string | array
    {
        return 3;
    }
}
