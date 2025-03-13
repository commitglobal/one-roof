<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ShelterAttributeResource\Pages;

use App\Enums\AttributeType;
use App\Filament\Admin\Resources\ShelterAttributeResource;
use App\Filament\Concerns\DisablesBreadcrumbs;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAttributes extends ListRecords
{
    use DisablesBreadcrumbs;

    protected static string $resource = ShelterAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // public function getTabs(): array
    // {
    //     return collect(AttributeType::options())
    //         ->map(
    //             fn (string $label, string $key) => Tab::make($key)
    //                 ->label($label)
    //                 ->modifyQueryUsing(fn (Builder $query) => $query->where('type', $key))
    //         )
    //         ->all();
    // }
}
