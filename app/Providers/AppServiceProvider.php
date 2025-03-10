<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Language;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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

        $this->app->singleton('languages', function () {
            try {
                return Language::all()->keyBy('code');
            } catch (QueryException $th) {
                logger()->warning('Failed to fetch languages from database');

                return collect([
                    Language::make([
                        'code' => 'en',
                    ]),
                ])->keyBy('code');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->enforceMorphMap();
        $this->setPasswordDefaults();

        tap($this->app->isLocal(), function (bool $shouldBeEnabled) {
            Model::preventLazyLoading($shouldBeEnabled);
            Model::preventAccessingMissingAttributes($shouldBeEnabled);
            // Model::preventSilentlyDiscardingAttributes($shouldBeEnabled);

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
            'beneficiary' => \App\Models\Beneficiary::class,
            'country' => \App\Models\Country::class,
            'document' => \App\Models\Document::class,
            'form' => \App\Models\Form::class,
            'location' => \App\Models\Location::class,
            'media' => \App\Models\Media::class,
            'membership' => \App\Models\Membership::class,
            'organization' => \App\Models\Organization::class,
            'request' => \App\Models\Request::class,
            'shelter' => \App\Models\Shelter::class,
            'stay' => \App\Models\Stay::class,
            'user' => \App\Models\User::class,
        ]);
    }

    protected function setPasswordDefaults(): void
    {
        $defaults = Password::min(8)
            ->uncompromised();

        Password::defaults(fn () => $defaults);

        // FilamentBreezy::setPasswordRules([
        //     static::passwordDefaults(),
        // ]);
    }
}
