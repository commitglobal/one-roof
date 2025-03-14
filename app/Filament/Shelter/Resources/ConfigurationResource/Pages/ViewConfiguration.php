<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\ConfigurationResource\Pages;

use App\Filament\Concerns\DisablesBreadcrumbs;
use App\Filament\Shelter\Resources\ConfigurationResource;
use App\Filament\Shelter\Resources\ConfigurationResource\Concerns\HasConfigurationMount;
use App\Models\Shelter\Attribute;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;

class ViewConfiguration extends ViewRecord
{
    use DisablesBreadcrumbs;
    use HasConfigurationMount;

    protected static string $resource = ConfigurationResource::class;

    public function getTitle(): string
    {
        return __('app.navigation.shelter_configuration');
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                Tabs::make()
                    ->persistTabInQueryString()
                    ->contained(false)
                    ->schema([
                        Tabs\Tab::make(__('app.shelter.profile'))
                            ->schema(static::getProfileTab()),
                        Tabs\Tab::make(Str::ucfirst(__('app.attribute.label.plural')))
                            ->schema(static::getAttributesTab())
                            ->visible(Attribute::query()->exists()),
                    ]),
            ]);
    }

    protected static function getProfileTab(): array
    {
        return [
            Section::make(__('app.shelter.profile'))
                ->headerActions([
                    Action::make('edit')
                        ->label(__('filament-actions::edit.single.label'))
                        ->url(static::getResource()::getUrl('profile'))
                        ->icon('heroicon-o-pencil-square')
                        ->color('gray')
                        ->outlined(),
                ])
                ->columns()
                ->schema([
                    TextEntry::make('name')
                        ->label(__('app.field.name')),

                    TextEntry::make('capacity')
                        ->label(__('app.field.capacity')),

                    TextEntry::make('country.name')
                        ->label(__('app.field.country')),

                    TextEntry::make('location.name')
                        ->label(__('app.field.location')),

                    TextEntry::make('address')
                        ->label(__('app.field.address'))
                        ->columnSpanFull(),

                    Fieldset::make(__('app.field.shelter_coordinator'))
                        ->columns(3)
                        ->schema([
                            TextEntry::make('coordinator.name')
                                ->label(__('app.field.name')),

                            TextEntry::make('coordinator.email')
                                ->label(__('app.field.email')),

                            TextEntry::make('coordinator.phone')
                                ->label(__('app.field.phone')),
                        ]),
                ]),
        ];
    }

    protected function getAttributesTab(): array
    {
        $variables = $this->getRecord()->variables;

        $schema = Attribute::query()
            ->whereAttribute()
            ->get()
            ->map(
                fn (Attribute $attribute, int $index) => TextEntry::make($attribute->name)
                    ->listWithLineBreaks()
                    ->state($variables->where('attribute_id', $attribute->getKey())->pluck('name'))
            )
            ->all();

        return [
            Section::make(Str::ucfirst(__('app.attribute.label.plural')))
                ->headerActions([
                    Action::make('edit')
                        ->label(__('filament-actions::edit.single.label'))
                        ->url(static::getResource()::getUrl('attributes'))
                        ->icon('heroicon-o-pencil-square')
                        ->color('gray')
                        ->outlined(),
                ])
                ->columns(3)
                ->schema($schema),
        ];
    }
}
