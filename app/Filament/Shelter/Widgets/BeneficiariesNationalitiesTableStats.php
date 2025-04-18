<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Widgets;

use App\Models\Beneficiary;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Str;
use Tpetry\QueryExpressions\Function\Aggregate\Count;
use Tpetry\QueryExpressions\Function\Aggregate\Min;
use Tpetry\QueryExpressions\Language\Alias;

class BeneficiariesNationalitiesTableStats extends BaseWidget
{
    protected static ?int $sort = 21;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('app.stats.beneficiaries.nationalities'))
            ->query(
                fn () => Beneficiary::query()
                    ->whereInShelter(Filament::getTenant())
                    ->join('countries', 'beneficiaries.nationality_id', 'countries.id')
                    ->select([
                        new Alias('countries.name', 'country_name'),
                        new Alias(new Count('*'), 'count'),
                        new Alias(new Min('beneficiaries.id'), 'id'),
                    ])
                    ->groupBy('country_name')
            )
            ->columns([
                TextColumn::make('country_name')
                    ->label(__('app.field.country'))
                    ->wrap(),

                TextColumn::make('count')
                    ->label(Str::ucfirst(__('app.beneficiary.label.plural')))
                    ->alignRight()
                    ->sortable()
                    ->numeric()
                    ->shrink(),
            ])
            ->defaultSort('count', 'desc')
            ->defaultPaginationPageOption(5);
    }
}
