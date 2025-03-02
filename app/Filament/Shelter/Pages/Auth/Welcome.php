<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class Welcome extends SimplePage
{
    use InteractsWithFormActions;
    use WithRateLimiting;

    public Authenticatable $user;

    public ?array $data = [];

    public function mount(Request $request): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        if (! $request->hasValidSignature()) {
            abort(Response::HTTP_FORBIDDEN, __('auth.invalid_signature'));
        }

        if (\is_null($this->user)) {
            abort(Response::HTTP_FORBIDDEN, __('auth.invalid_user'));
        }

        if ($this->user->hasSetPassword()) {
            abort(Response::HTTP_FORBIDDEN, __('auth.link_already_used'));
        }

        $this->form->fill([
            'email' => $this->user->email,
        ]);
    }

    public function getTitle(): string
    {
        return __('auth.set_password');
    }

    public function handle(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'email' => __('filament::login.messages.throttled', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]),
            ]);
        }

        $this->user->setPassword(data_get($this->form->getState(), 'password'));

        $this->user->activate();

        Filament::auth()->login($this->user);

        return app(LoginResponse::class);
    }
}
