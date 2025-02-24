<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Forms\Components\DateTimePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public static string $defaultDateDisplayFormat = 'd.m.Y';

    public static string $defaultDateTimeDisplayFormat = 'd.m.Y H:i';

    public static string $defaultDateTimeWithSecondsDisplayFormat = 'd.m.Y H:i:s';

    public static string $defaultTimeDisplayFormat = 'H:i';

    public static string $defaultTimeWithSecondsDisplayFormat = 'H:i:s';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerMacros();
        $this->setDefaultDateTimeDisplayFormats();

        tap($this->getAppVersion(), function (string $version) {
            Config::set('app.version', $version);
            Config::set('sentry.release', $version);

            FilamentView::registerRenderHook(
                PanelsRenderHook::FOOTER,
                fn () => view('filament.version', [
                    'version' => $version,
                ]),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->enforceMorphMap();

        tap($this->app->isLocal(), function (bool $shouldBeEnabled) {
            Model::preventLazyLoading($shouldBeEnabled);
            Model::preventAccessingMissingAttributes($shouldBeEnabled);
            Model::preventSilentlyDiscardingAttributes($shouldBeEnabled);
        });

        TextEntry::configureUsing(function (TextEntry $entry) {
            return $entry->default('—');
        });
    }

    /**
     * Read the application version.
     *
     * @return string
     */
    public function getAppVersion(): string
    {
        $version = base_path('.version');

        if (! file_exists($version)) {
            return 'develop';
        }

        return trim(file_get_contents($version));
    }

    protected function enforceMorphMap(): void
    {
        Relation::enforceMorphMap([
            'country' => \App\Models\Country::class,
            'location' => \App\Models\Location::class,
            'media' => \App\Models\Media::class,
            'organization' => \App\Models\Organization::class,
            'user' => \App\Models\User::class,
        ]);
    }

    protected function registerMacros(): void
    {
        Column::macro('shrink', fn () => $this->extraHeaderAttributes(['class' => 'w-1']));
    }

    protected function setDefaultDateTimeDisplayFormats(): void
    {
        Table::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Table::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Table::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;

        Infolist::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        Infolist::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        Infolist::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;

        DateTimePicker::$defaultDateDisplayFormat = static::$defaultDateDisplayFormat;
        DateTimePicker::$defaultDateTimeDisplayFormat = static::$defaultDateTimeDisplayFormat;
        DateTimePicker::$defaultDateTimeWithSecondsDisplayFormat = static::$defaultDateTimeWithSecondsDisplayFormat;
        DateTimePicker::$defaultTimeDisplayFormat = static::$defaultTimeDisplayFormat;
        DateTimePicker::$defaultTimeWithSecondsDisplayFormat = static::$defaultTimeWithSecondsDisplayFormat;
    }
}
