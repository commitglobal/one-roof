<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Request;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Str;
use Tpetry\QueryExpressions\Function\Aggregate\Count;
use Tpetry\QueryExpressions\Function\Aggregate\Min;
use Tpetry\QueryExpressions\Language\Alias;

class RequestsStatusTableStats extends BaseWidget
{
    protected static ?int $sort = 22;

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('app.stats.requests.status'))
            ->query(
                fn () => Request::query()
                    ->select([
                        'status',
                        new Alias(new Count('*'), 'count'),
                        new Alias(new Min('id'), 'id'),
                    ])
                    ->groupBy('status')
            )
            ->columns([
                TextColumn::make('status')
                    ->label(__('app.field.status'))
                    ->sortable(),

                TextColumn::make('count')
                    ->label(Str::ucfirst(__('app.request.label.plural')))
                    ->alignRight()
                    ->sortable()
                    ->numeric()
                    ->shrink(),
            ])
            ->defaultSort('count', 'desc');
    }
}
