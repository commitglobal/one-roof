<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Concerns\BelongsToOrganization;
use App\Concerns\HasStatus;
use App\Concerns\MustSetInitialPassword;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasLocalePreference
{
    use BelongsToOrganization;
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasStatus;
    use MustSetInitialPassword;
    use Notifiable;

    protected static string $factory = UserFactory::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function booted(): void
    {
        static::created(function (self $user): void {
            $user->loadMissing('organization.shelters');

            if (filled($user->organization)) {
                $user->organization->shelters->each(function (Shelter $shelter) use ($user) {
                    $shelter->users()->attach([
                        $user->id => ['role' => 'admin'],
                    ]);
                });
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            // TODO: implement admin panel access logic
            return true;
        }

        if ($panel->getId() === 'shelters') {
            // TODO: implement shelters panel access logic
        }

        return false;
    }

    public function preferredLocale(): string
    {
        return $this->locale ?? app()->getLocale();
    }
}
