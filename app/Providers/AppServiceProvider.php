<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
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

            if ($shouldBeEnabled && env('APP_DEBUG_QUERY', false)) {
                DB::listen(function ($query) {
                    logger()->debug($query->sql, [
                        'bindings' => $query->bindings,
                        'time' => $query->time,
                    ]);
                });
            }
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
            'shelter' => \App\Models\Shelter::class,
            'user' => \App\Models\User::class,
        ]);
    }
}
