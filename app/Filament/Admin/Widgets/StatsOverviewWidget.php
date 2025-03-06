<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Beneficiary;
use App\Models\Organization;
use App\Models\Shelter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make(
                __('app.stats.overview.organizations'),
                Organization::count()
            ),

            Stat::make(
                __('app.stats.overview.shelters'),
                Shelter::count()
            ),

            Stat::make(
                __('app.stats.overview.beneficiaries'),
                Beneficiary::count()
            ),
        ];
    }
}
