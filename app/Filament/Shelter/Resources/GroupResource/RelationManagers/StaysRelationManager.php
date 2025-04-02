<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\GroupResource\RelationManagers;

use App\Models\Shelter;
use App\Models\Stay;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StaysRelationManager extends RelationManager
{
    protected static string $relationship = 'stays';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('app.field.group_members');
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('app.field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->shrink(),

                TextColumn::make('beneficiary.name')
                    ->label(__('app.field.name'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('start_date')
                    ->label(__('app.field.start_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('app.field.end_date'))
                    ->date()
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\AssociateAction::make()
                    ->modalHeading(__('app.field.group_members'))
                    ->recordSelect(function (Select $select) {
                        $staysWithGroup = Stay::query()
                            ->whereBelongsTo($this->ownerRecord->shelter)
                            ->whereNotNull('group_id')
                            ->get();

                        return $select
                            ->getSearchResultsUsing(fn (string $search) => $this->getOptions($this->ownerRecord->shelter, $search))
                            ->options(fn () => $this->getOptions($this->ownerRecord->shelter))
                            ->disableOptionWhen(function ($value) use ($staysWithGroup) {
                                return $staysWithGroup->contains('id', $value);
                            });
                    }),
            ])
            ->actions([
                Tables\Actions\DissociateAction::make(),
            ])
            ->paginated(false);
    }

    protected function getOptions(Shelter $shelter, ?string $search = null): array
    {
        if (filled($search)) {
            $options = Stay::search($search)
                ->query(
                    fn (Builder $query) => $query
                        ->whereBelongsTo($shelter)
                        ->with('beneficiary:id,name')
                )
                ->where('shelter_id', $shelter->id)
                ->limit(50)
                ->get();
        } else {
            $options = Stay::query()
                ->whereBelongsTo($shelter)
                ->with('beneficiary:id,name')
                ->limit(50)
                ->get();
        }

        return $options
            ->pluck('title_with_beneficiary_name', 'id')
            ->all();
    }
}
