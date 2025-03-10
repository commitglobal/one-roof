<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Concerns\HasRole;
use App\Concerns\HasStatus;
use App\Concerns\HasUlid;
use App\Concerns\LogsActivity;
use App\Concerns\MustSetInitialPassword;
use App\Enums\User\Role;
use App\Notifications\WelcomeAdminNotification;
use App\Notifications\WelcomeOrganizationNotification;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable implements FilamentUser, HasTenants, HasLocalePreference
{
    use BelongsToOrganization;
    use CausesActivity;
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasRole;
    use HasStatus;
    use HasUlid;
    use LogsActivity;
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
            'password' => 'hashed',
        ];
    }

    public function shelters(): BelongsToMany
    {
        return $this->belongsToMany(Shelter::class, Membership::class)
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');
    }

    public static function booted(): void
    {
        static::created(function (self $user): void {
            $user->loadMissing('organization.shelters');

            if (filled($user->organization)) {
                $user->organization->shelters->each(function (Shelter $shelter) use ($user) {
                    $shelter->users()->attach([
                        $user->id => ['role' => Role::SHELTER_ADMIN],
                    ]);
                });
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // return true;
        if ($panel->getId() === 'admin') {
            return $this->hasElevatedPrivileges();
        }

        if ($panel->getId() === 'shelter') {
            return true;
        }

        return false;
    }

    public function getTenants(Panel $panel): Collection
    {
        if ($panel->getId() === 'shelter') {
            return $this->shelters;
        }

        return collect();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->shelters->contains($tenant);
    }

    public function preferredLocale(): string
    {
        return $this->locale ?? app()->getLocale();
    }

    public function sendWelcomeNotification(): void
    {
        if ($this->isSuperAdmin()) {
            $this->notify(new WelcomeAdminNotification);
        }

        if (filled($this->organization_id)) {
            $this->notify(new WelcomeOrganizationNotification);
        }
    }
}
