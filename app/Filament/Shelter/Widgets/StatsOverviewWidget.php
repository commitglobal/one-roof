<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Widgets;

use App\Models\Beneficiary;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make(
                __('app.stats.overview.beneficiaries_in_shelter'),
                Beneficiary::query()
                    ->whereCurrentlyInShelter(Filament::getTenant())
                    ->count()
            ),

            Stat::make(
                __('app.stats.overview.beneficiaries'),
                Beneficiary::query()
                    ->whereInShelter(Filament::getTenant())
                    ->count()
            ),
        ];
    }
}
