<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\OrganizationResource\Schemas;

use App\Forms\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\TextInput;

class AdminsForm
{
    public static function getSchema(): array
    {
        return [
            TableRepeater::make('admins')
                ->label(__('app.field.admins'))
                ->hiddenLabel()
                ->relationship('admins')
                ->columns()
                ->minItems(1)
                ->headers([
                    Header::make('name')
                        ->label(__('app.field.name'))
                        ->markAsRequired(),

                    Header::make('email')
                        ->label(__('app.field.email'))
                        ->markAsRequired(),

                    Header::make('phone')
                        ->label(__('app.field.phone'))
                        ->markAsRequired(),
                ])
                ->schema(static::getIndividualSchema())
                ->addActionLabel(__('app.organization.steps.admins.add')),
        ];
    }

    public static function getIndividualSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('app.field.name'))
                ->required(),

            TextInput::make('email')
                ->label(__('app.field.email'))
                ->unique('users', 'email')
                ->email()
                ->required(),

            TextInput::make('phone')
                ->label(__('app.field.phone'))
                ->tel()
                ->required(),
        ];
    }
}
