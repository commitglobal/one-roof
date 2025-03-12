<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Widgets;

use App\Models\Beneficiary;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $capacity = Filament::getTenant()->capacity;

        $currentBeneficiaries = Beneficiary::query()
            ->whereCurrentlyInShelter(Filament::getTenant())
            ->count();

        $totalBeneficiaries = Beneficiary::query()
            ->whereInShelter(Filament::getTenant())
            ->count();

        return [
            Stat::make(
                __('app.stats.overview.beneficiaries_in_shelter'),
                Number::format($currentBeneficiaries)
            ),

            Stat::make(
                __('app.stats.overview.available_places'),
                \sprintf(
                    '%s / %s',
                    Number::format($capacity - $currentBeneficiaries),
                    Number::format($capacity)
                )
            ),

            Stat::make(
                __('app.stats.overview.beneficiaries'),
                Number::format($totalBeneficiaries)
            ),
        ];
    }
}
