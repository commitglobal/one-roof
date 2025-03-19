<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\RequestResource\Schemas;

use App\Infolists\Components\Notice;
use App\Infolists\Components\TableRepeatableEntry;
use App\Models\Request;
use App\Models\Shelter;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class RequestInfolist
{
    public static function getSchema(): array
    {
        return [
            Section::make()
                ->columns(3)
                ->schema([
                    Notice::make('referral_notice')
                        ->icon('heroicon-s-information-circle')
                        ->visible(fn (Request $record) => $record->isReferred())
                        ->color('success')
                        ->state(function (Request $record) {
                            $event = $record->activities()
                                ->where('event', 'referred')
                                ->first();

                            $shelter = Shelter::find(data_get($event, 'changes.old.shelter_id'));

                            return __('app.request.referred_by', ['name' => $shelter->name]);
                        }),

                    TextEntry::make('referral_notes')
                        ->label(__('app.field.referral_notes'))
                        ->visible(fn (Request $record) => $record->isReferred())
                        ->columnSpanFull(),

                    TextEntry::make('status')
                        ->label(__('app.field.status'))
                        ->badge(),

                    TextEntry::make('id')
                        ->label(__('app.field.id'))
                        ->prefix('#'),

                    TextEntry::make('created_at')
                        ->label(__('app.field.created_at'))
                        ->dateTime(),

                    TextEntry::make('start_date')
                        ->label(__('app.field.start_date'))
                        ->date(),

                    TextEntry::make('end_date')
                        ->label(__('app.field.end_date'))
                        ->date(),

                    TextEntry::make('reason_rejected')
                        ->label(__('app.field.reason_rejected'))
                        ->visible(fn (Request $record) => $record->isRejected()),

                ]),

            Grid::make()
                ->columns(3)
                ->schema([
                    Section::make(__('app.field.requester'))
                        ->columnSpan(1)
                        ->visible(fn (Request $record) => filled($record->requester))
                        ->schema([
                            TextEntry::make('requester.name')
                                ->label(__('app.field.name')),
                            TextEntry::make('requester.email')
                                ->label(__('app.field.email')),
                            TextEntry::make('requester.phone')
                                ->label(__('app.field.phone')),
                        ]),

                    Section::make(__('app.field.beneficiary'))
                        ->columns(3)
                        ->columnSpan(fn (Request $record) => filled($record->requester) ? 2 : 'full')
                        ->schema([
                            TextEntry::make('beneficiary.name')
                                ->label(__('app.field.name')),
                            TextEntry::make('beneficiary.email')
                                ->label(__('app.field.email')),
                            TextEntry::make('beneficiary.phone')
                                ->label(__('app.field.phone')),

                            TextEntry::make('gender')
                                ->label(__('app.field.gender')),

                            TextEntry::make('age')
                                ->label(__('app.field.age')),

                            TextEntry::make('departureCountry.name')
                                ->label(__('app.field.departure_country')),

                            TextEntry::make('nationality.name')
                                ->label(__('app.field.nationality')),
                        ]),
                ]),

            Section::make(__('app.field.special_needs'))
                ->visible(fn (Request $record) => filled($record->special_needs))
                ->collapsible()
                ->columns(3)
                ->schema([
                    TextEntry::make('special_needs')
                        ->label(__('app.field.special_needs'))
                        ->columnSpan(1),

                    TextEntry::make('special_needs_notes')
                        ->label(__('app.field.special_needs_notes'))
                        ->columnSpan(2),
                ]),

            Section::make(__('app.field.group'))
                ->visible(fn (Request $record) => filled($record->group))
                ->collapsible()
                ->schema([
                    TableRepeatableEntry::make('group')
                        ->label(__('app.field.group'))
                        ->hiddenLabel()
                        ->schema([
                            TextEntry::make('name')
                                ->label(__('app.field.name')),

                            TextEntry::make('age')
                                ->label(__('app.field.age')),

                            TextEntry::make('notes')
                                ->label(__('app.field.notes')),
                        ])
                        ->contained(false),
                ]),

            Section::make(__('app.field.notes'))
                ->collapsible()
                ->schema([
                    TextEntry::make('notes')
                        ->label(__('app.field.notes'))
                        ->hiddenLabel(),
                ]),
        ];
    }
}
