<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\Carbon;
use Filament\Actions\ActionGroup;
use Filament\Actions\MountableAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Infolists;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Filament\Tables;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public static string $defaultDateDisplayFormat = 'd.m.Y';

    public static string $defaultDateTimeDisplayFormat = 'd.m.Y H:i';

    public static string $defaultDateTimeWithSecondsDisplayFormat = 'd.m.Y H:i:s';

    public static string $defaultTimeDisplayFormat = 'H:i';

    public static string $defaultTimeWithSecondsDisplayFormat = 'H:i:s';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->setDateTimeDisplayFormats();

        $this->configureFormComponents();
        $this->configureInfolistComponents();
        $this->configureTableComponents();
        $this->configureActions();
        $this->configurePages();
        $this->renderHooks();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::registerNavigationGroups([
            __('app.navigation.activity'),
            __('app.navigation.configurations'),
        ]);

        Filament::registerNavigationItems([
            NavigationItem::make(__('app.navigation.manual'))
                ->icon('heroicon-o-bookmark-square')
                ->url('https://www.untecho.mx/es/manual', true)
                ->group(__('app.navigation.configurations'))
                ->sort(9999),
        ]);

        FilamentColor::register([
            'primary' => Color::Green,
        ]);
    }

    protected function setDateTimeDisplayFormats(): void
    {
        Tables\Table::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Tables\Table::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Tables\Table::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;

        Infolists\Infolist::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Infolists\Infolist::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Infolists\Infolist::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;

        Forms\Components\DateTimePicker::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Forms\Components\DateTimePicker::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Forms\Components\DateTimePicker::$defaultDateTimeWithSecondsDisplayFormat = static::$defaultDateTimeWithSecondsDisplayFormat;
        Forms\Components\DateTimePicker::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;
        Forms\Components\DateTimePicker::$defaultTimeWithSecondsDisplayFormat = static::$defaultTimeWithSecondsDisplayFormat;

        Carbon::macro('toFormattedDate', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultDateDisplayFormat));
        Carbon::macro('toFormattedDateTime', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultDateTimeDisplayFormat));
        Carbon::macro('toFormattedDateTimeWithSeconds', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultDateTimeWithSecondsDisplayFormat));
        Carbon::macro('toFormattedTime', fn () => $this->translatedFormat(FilamentServiceProvider::$defaultTimeDisplayFormat));
    }

    protected function configureFormComponents(): void
    {
        Forms\Components\Repeater::configureUsing(function (Forms\Components\Repeater $repeater) {
            return $repeater->addActionAlignment(Alignment::Left);
        });

        Forms\Components\TextInput::configureUsing(function (Forms\Components\TextInput $input) {
            // Disable restrictive phone format
            return $input->telRegex('/^.+$/');
        });

        Forms\Components\Field::macro('translatable', function (?array $localeSpecificRules = null) {
            return Tabs::make('translations')
                ->contained(false)
                ->tabs(
                    collect(filament('spatie-laravel-translatable')->getDefaultLocales())
                        ->map(function ($label, $key) use ($localeSpecificRules) {
                            $locale = \is_string($key) ? $key : $label;

                            $clone = $this
                                ->getClone()
                                ->name("{$this->getName()}.{$locale}")
                                ->label($this->getLabel())
                                ->statePath("{$this->getStatePath(false)}.{$locale}");

                            if ($locale !== app()->getFallbackLocale()) {
                                $clone->required(false)
                                    ->nullable();
                            }

                            if ($rules = data_get($localeSpecificRules, $locale)) {
                                $clone->rules($rules);
                            }

                            return Tabs\Tab::make($locale)
                                ->label(\is_string($key) ? $label : strtoupper($locale))
                                ->schema([$clone]);
                        })
                        ->toArray()
                );
        });
    }

    protected function configureInfolistComponents(): void
    {
        Infolists\Components\TextEntry::configureUsing(function (Infolists\Components\TextEntry $entry) {
            return $entry->default('—');
        });
    }

    protected function configureTableComponents(): void
    {
        Tables\Table::configureUsing(function (Tables\Table $table) {
            return $table
                ->paginationPageOptions([5, 10, 25, 50])
                ->defaultSort('id', 'desc');
        });

        Tables\Columns\Column::macro('shrink', function () {
            return $this->extraHeaderAttributes(['class' => 'w-1']);
        });
    }

    protected function configureActions(): void
    {
        MountableAction::configureUsing(function (MountableAction $action) {
            $action->modalFooterActionsAlignment(Alignment::End);

            if (method_exists($action, 'createAnother')) {
                $action->createAnother(false);
            }
        });

        ActionGroup::configureUsing(function (ActionGroup $group) {
            return $group
                ->label(__('app.more_actions'))
                ->iconPosition(IconPosition::After)
                ->icon('heroicon-o-chevron-down')
                ->color('gray')
                ->outlined()
                ->button();
        }, isImportant: true);
    }

    protected function configurePages(): void
    {
        Page::alignFormActionsEnd();

        CreateRecord::disableCreateAnother();
    }

    protected function renderHooks(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::FOOTER,
            fn () => view('filament.version', [
                'version' => config()->get('app.version'),
            ]),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_PROFILE_AFTER,
            fn () => view('components.locale-switcher.panel', [
                'locales' => active_locales(),
            ]),
        );
    }
}
