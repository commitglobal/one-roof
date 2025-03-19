<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Enums\Form\Type;
use App\Models\Form;

class BeneficiaryDynamicForm
{
    public static function getSchema(): array
    {
        return Form::render(Type::PERSONAL);
    }
}
