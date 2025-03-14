<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ShelterAttribute;
use App\Models\User;

class ShelterAttributePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShelterAttribute $shelterAttribute): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShelterAttribute $shelterAttribute): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShelterAttribute $shelterAttribute): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShelterAttribute $shelterAttribute): bool
    {
        return $this->delete($user, $shelterAttribute);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShelterAttribute $shelterAttribute): bool
    {
        return $this->delete($user, $shelterAttribute);
    }
}
