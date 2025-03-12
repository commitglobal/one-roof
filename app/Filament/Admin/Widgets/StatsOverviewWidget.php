<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Beneficiary;
use App\Models\Organization;
use App\Models\Shelter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make(
                __('app.stats.overview.organizations'),
                Number::format(Organization::count())
            ),

            Stat::make(
                __('app.stats.overview.shelters'),
                Number::format(Shelter::count())
            ),

            Stat::make(
                __('app.stats.overview.beneficiaries'),
                Number::format(Beneficiary::count())
            ),
        ];
    }
}
