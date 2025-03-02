<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\User\Role;

trait HasRole
{
    public function initializeHasRole(): void
    {
        $this->casts['role'] = Role::class;

        $this->fillable[] = 'role';
    }

    public function hasRole(Role | string $role): bool
    {
        return (bool) $this->role?->is($role);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SUPER_ADMIN);
    }

    public function isSuperUser(): bool
    {
        return $this->hasRole(Role::SUPER_USER);
    }

    public function isShelterAdmin(): bool
    {
        return $this->hasRole(Role::SHELTER_ADMIN);
    }

    public function isShelterUser(): bool
    {
        return $this->hasRole(Role::SHELTER_USER);
    }

    public function hasElevatedPrivileges(): bool
    {
        return $this->isSuperAdmin() || $this->isSuperUser();
    }

    public function hasShelterPrivileges(): bool
    {
        return $this->isShelterAdmin() || $this->isShelterUser();
    }
}
