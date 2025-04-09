<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\RequestResource\Widgets;

use App\Filament\Shelter\Resources\RequestResource\Actions\Tables\ReferAction;
use App\Models\Request;
use App\Models\Shelter;
use App\Models\ShelterAttribute;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class ReferToShelterWidget extends BaseWidget
{
    public ?Request $record = null;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $attributes = ShelterAttribute::query()
            ->with('shelterVariables')
            ->get();

        return $table
            ->query(
                fn () => Shelter::query()
                    ->whereListed()
                    ->whereNot('id', Filament::getTenant()->id)
                    ->with([
                        'country',
                        'location',
                        'shelterVariables',
                    ])
            )
            ->contentGrid([
                'md' => 2,
                '2xl' => 3,
            ])
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->size(TextColumnSize::Medium)
                        ->weight(FontWeight::Bold)
                        ->searchable(),

                    TextColumn::make('full_address')
                        ->color(Color::Gray)
                        ->searchable('address'),

                    Split::make([
                        TextColumn::make('capacity')
                            ->description(__('app.field.capacity'), 'above'),

                        TextColumn::make('coordinator.phone')
                            ->description(__('app.field.phone'), 'above'),
                    ]),

                    ...$this->getShelterAttributes(),
                ])->extraAttributes([
                    'class' => 'gap-y-4',
                ]),
            ])
            ->actions([
                ReferAction::make()
                    ->arguments([
                        'request' => $this->record,
                    ]),
            ])
            ->actionsAlignment('end')
            ->filters([
                SelectFilter::make('location')
                    ->relationship('location', 'name'),

                ...$attributes->map(
                    fn (ShelterAttribute $shelterAttribute) => SelectFilter::make("attribute.{$shelterAttribute->id}")
                        ->query(fn (Builder $query, array $state) => $query->whereHasShelterVariables($state))
                        ->options($shelterAttribute->shelterVariables->pluck('name', 'id'))
                        ->label($shelterAttribute->name)
                        ->multiple()
                ),

            ], FiltersLayout::AboveContent)
            ->paginated(false);
    }

    protected function getShelterAttributes(): Collection
    {
        return ShelterAttribute::query()
            ->whereAttribute()
            ->get()
            ->map(
                fn (ShelterAttribute $attribute, int $index) => TextColumn::make($attribute->name)
                    ->description($attribute->name, 'above')
                    ->state(function (Shelter $record) use ($attribute) {
                        $variables = $record->shelterVariables
                            ->where('shelter_attribute_id', $attribute->getKey())
                            ->pluck('name');

                        return filled($variables) ? $variables : new HtmlString('&mdash;');
                    })
            )
            ->chunk(2)
            ->map(fn (Collection $columns) => Split::make($columns->all()));
    }
}
