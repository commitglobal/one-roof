<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
            $this->setLocaleForGuest();
        } else {
            $this->setLocaleForUser();
        }

        return $next($request);
    }

    protected function setLocaleForUser(): void
    {
        $locale = Auth::user()->preferredLocale();

        if (blank($locale)) {
            return;
        }

        App::setLocale($locale);
    }

    protected function setLocaleForGuest(): void
    {
        //
    }
}
