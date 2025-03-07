<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\User\Role;
use App\Events\OrganizationCreated;
use App\Models\Shelter;
use App\Models\User;

class SyncOrganizationAdmins
{
    public function handle(OrganizationCreated $event): void
    {
        $event->organization->shelters
            ->each(fn (Shelter $shelter) => $shelter->users()->sync(
                $event->organization->admins
                    ->mapWithKeys(fn (User $user) => [
                        $user->id => ['role' => Role::SHELTER_ADMIN],
                    ])
            ));
    }
}
