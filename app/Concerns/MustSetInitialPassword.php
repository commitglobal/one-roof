<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Support\Str;
use SensitiveParameter;

trait MustSetInitialPassword
{
    public function initializeMustSetInitialPassword(): void
    {
        $this->fillable[] = 'password_set_at';

        $this->casts['password_set_at'] = 'datetime';
    }

    protected static function bootMustSetInitialPassword(): void
    {
        static::creating(function (self $user) {
            if (! $user->password) {
                $user->password = Str::random(128);
            }
        });

        static::created(function (self $user) {
            $user->sendWelcomeNotification();
        });
    }

    public function hasSetPassword(): bool
    {
        return filled($this->password_set_at);
    }

    public function setPassword(#[SensitiveParameter] string $password): bool
    {
        return $this->update([
            'password' => $password,
            'password_set_at' => now(),
        ]);
    }

    abstract public function sendWelcomeNotification(): void;
}
