<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Form;
use App\Models\User;

class FormPolicy
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
    public function view(User $user, Form $form): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Form $form): bool
    {
        return $form->isDraft();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Form $form): bool
    {
        return $form->isDraft();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Form $form): bool
    {
        return $this->delete($user, $form);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Form $form): bool
    {
        return $this->delete($user, $form);
    }
}
