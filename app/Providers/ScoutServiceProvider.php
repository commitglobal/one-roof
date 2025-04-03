<?php

declare(strict_types=1);

namespace App\Providers;

use HaydenPierce\ClassFinder\ClassFinder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\Searchable;

class ScoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('searchable-models', function (): Collection {
            $classes = ClassFinder::getClassesInNamespace('App\\Models', ClassFinder::RECURSIVE_MODE);

            return collect($classes)
                ->filter(function (string $class) {
                    if (! is_subclass_of($class, Model::class)) {
                        return false;
                    }

                    return \in_array(Searchable::class, class_uses_recursive($class));
                })
                ->values();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Config::set(
            'scout.typesense.model-settings',
            app('searchable-models')
                ->mapWithKeys(fn (string $model) => [
                    $model => $model::typesenseModelSettings(),
                ])
                ->all()
        );
    }
}
