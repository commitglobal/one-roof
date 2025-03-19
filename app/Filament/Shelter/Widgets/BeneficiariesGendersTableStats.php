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

class BeneficiariesGendersTableStats extends BaseWidget
{
    protected static ?int $sort = 20;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('app.stats.beneficiaries.genders'))
            ->query(
                fn () => Beneficiary::query()
                    ->whereInShelter(Filament::getTenant())
                    ->select([
                        'gender',
                        new Alias(new Count('*'), 'count'),
                        new Alias(new Min('id'), 'id'),
                    ])
                    ->groupBy('gender')
            )
            ->columns([
                TextColumn::make('gender')
                    ->label(__('app.field.gender'))
                    ->sortable(),

                TextColumn::make('count')
                    ->label(Str::ucfirst(__('app.beneficiary.label.plural')))
                    ->alignRight()
                    ->sortable()
                    ->numeric()
                    ->shrink(),
            ])
            ->defaultSort('count', 'desc');
    }
}
