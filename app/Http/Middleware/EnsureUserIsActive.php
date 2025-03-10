<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Filament::auth()->user();

        if (! $user->isActive() || ! $user->organization?->isActive()) {
            Filament::auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Notification::make()
                ->title(__('auth.suspended.title'))
                ->body(__('auth.suspended.body'))
                ->danger()
                ->send();

            return redirect()->to(Filament::getCurrentPanel()->getLoginUrl());
        }

        return $next($request);
    }
}
