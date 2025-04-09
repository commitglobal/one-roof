<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guest()) {
            $this->setLocaleForGuest($request);
        } else {
            $this->setLocaleForUser($request);
        }

        Number::useLocale(App::getLocale());

        return $next($request);
    }

    protected function setLocaleForUser(Request $request): void
    {
        $locale = Auth::user()->preferredLocale();

        if (blank($locale)) {
            return;
        }

        App::setLocale($locale);
    }

    protected function setLocaleForGuest(Request $request): void
    {
        $locale = $request->query('lang');

        if (blank($locale) || active_locales()->doesntContain($locale)) {
            return;
        }

        App::setLocale($locale);
    }
}
