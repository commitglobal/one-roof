<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class PreferredLocaleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function __invoke(string $locale): RedirectResponse
    {
        if (active_locales()->contains('code', $locale)) {
            auth()->user()->update([
                'locale' => $locale,
            ]);
        }

        return redirect()->back();
    }
}
