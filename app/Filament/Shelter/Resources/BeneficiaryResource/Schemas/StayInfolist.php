<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Filament\Shelter\Resources\GroupResource;
use App\Filament\Shelter\Resources\RequestResource;
use App\Models\Stay;
use Carbon\Carbon;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class StayInfolist
{
    public static function getSchema(): array
    {
        return [
            Section::make()
                ->columns()
                ->schema([
                    TextEntry::make('id')
                        ->label(__('app.field.id'))
                        ->prefix('#'),

                    TextEntry::make('created_at')
                        ->label(__('app.field.created_at'))
                        ->dateTime(),
                ]),

            Section::make(__('app.stay.details'))
                ->columns()
                ->schema([
                    TextEntry::make('start_date')
                        ->label(__('app.field.start_date'))
                        ->date(),

                    static::getEndDateTextEntry(),

                    TextEntry::make('has_children')
                        ->label(__('app.field.has_children'))
                        ->visible(fn (Stay $record) => ! $record->has_children)
                        ->state(__('app.no')),

                    Group::make()
                        ->visible(fn (Stay $record) => $record->has_children)
                        ->columnSpanFull()
                        ->schema([
                            TextEntry::make('children_count')
                                ->label(__('app.field.children_count'))
                                ->numeric(),

                            TextEntry::make('children_notes')
                                ->label(__('app.field.children_notes')),
                        ]),

                    TextEntry::make('request.title')
                        ->visible(fn (Stay $record) => $record->has_request)
                        ->label(__('app.field.request'))
                        ->url(fn (Stay $record) => RequestResource::getUrl('view', [
                            'record' => $record->request_id,
                        ]))
                        ->color('primary'),

                    TextEntry::make('group.title')
                        ->visible(fn (Stay $record) => $record->has_group)
                        ->label(__('app.field.group'))
                        ->url(fn (Stay $record) => GroupResource::getUrl('view', [
                            'record' => $record->group_id,
                        ]))
                        ->color('primary'),
                ]),
        ];
    }

    public static function getEndDateTextEntry(): TextEntry
    {
        return TextEntry::make('end_date')
            ->label(__('app.field.end_date'))
            ->date()
            ->formatStateUsing(function (TextEntry $component, $state) {
                if (blank($state) || $component->getDefaultState() === $state) {
                    return __('app.stay.indefinite');
                }

                return Carbon::parse($state)
                    ->setTimezone($component->getTimezone())
                    ->translatedFormat($component->evaluate(Infolist::$defaultDateDisplayFormat));
            });
    }
}
