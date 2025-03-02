<?php

declare(strict_types=1);

namespace App\Enums\User;

use App\Enums\Concerns\Arrayable;
use App\Enums\Concerns\Comparable;
use Filament\Support\Contracts\HasLabel;

enum Role: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case SUPER_ADMIN = 'super_admin';
    case SUPER_USER = 'super_user';
    case SHELTER_ADMIN = 'shelter_admin';
    case SHELTER_USER = 'shelter_user';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => __('app.user.role.super_admin'),
            self::SUPER_USER => __('app.user.role.super_user'),
            self::SHELTER_ADMIN => __('app.user.role.shelter_admin'),
            self::SHELTER_USER => __('app.user.role.shelter_user'),
        };
    }
}
