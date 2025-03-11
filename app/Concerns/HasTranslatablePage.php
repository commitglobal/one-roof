<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Support\Facades\App;
use Livewire\Attributes\Url;

trait HasTranslatablePage
{
    #[Url(as: 'lang')]
    public string $locale;

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;

        if (active_locales()->contains($locale)) {
            App::setLocale($locale);
        }
    }
}
