<?php

declare(strict_types=1);

use App\Models\Language;
use Illuminate\Support\Collection;

if (! function_exists('locales')) {
    /**
     * Return the available locales.
     *
     * @return Collection
     */
    function locales(): Collection
    {
        return app('languages');
    }
}

if (! function_exists('active_locales')) {
    /**
     * Return the currently enabled locales.
     *
     * @return Collection
     */
    function active_locales(): Collection
    {
        return app('languages')
            ->reject(fn (Language $language) => ! $language->enabled);
    }
}
