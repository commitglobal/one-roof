<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Organization;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrganizationCreated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Organization $organization;

    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }
}
