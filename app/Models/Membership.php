<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasRole;
use App\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Membership extends Pivot
{
    use HasRole;
    use LogsActivity;

    /**
     * The table associated with the pivot model.
     *
     * @var string
     */
    protected $table = 'shelter_user';
}
