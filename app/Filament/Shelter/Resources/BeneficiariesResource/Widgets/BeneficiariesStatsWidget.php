<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiariesResource\Widgets;

use App\Models\Stay;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class BeneficiariesStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $currentBeneficiaries = Stay::query()
            ->whereInShelter(Filament::getTenant())
            ->whereCurrent()
            ->count();

        $totalBeneficiaries = Stay::query()
            ->whereInShelter(Filament::getTenant())
            ->count();

        return [
            Stat::make(
                __('app.stats.overview.beneficiaries_in_shelter'),
                Number::format($currentBeneficiaries)
            ),

            Stat::make(
                __('app.stats.overview.beneficiaries'),
                Number::format($totalBeneficiaries)
            ),
        ];
    }
}
