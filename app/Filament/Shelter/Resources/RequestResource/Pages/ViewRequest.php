<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\RequestResource\Pages;

use App\Filament\Admin\Resources\RequestResource\Actions\MarkAsDuplicateAction;
use App\Filament\Admin\Resources\RequestResource\Actions\MarkAsObsoleteAction;
use App\Filament\Admin\Resources\RequestResource\Actions\MarkAsPendingAction;
use App\Filament\Admin\Resources\RequestResource\Actions\RejectAction;
use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Shelter\Resources\RequestResource;
use App\Filament\Shelter\Resources\RequestResource\Actions\AcceptAction;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ViewRecord;

class ViewRequest extends ViewRecord
{
    use UsesBreadcrumbFromTitle;

    protected static string $resource = RequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            AcceptAction::make(),

            // TODO: figure out if we need different implementations for the shelter panel
            ActionGroup::make([
                RejectAction::make(),

                ActionGroup::make([
                    MarkAsPendingAction::make(),
                    MarkAsObsoleteAction::make(),
                    MarkAsDuplicateAction::make(),
                ])->dropdown(false),
            ]),
        ];
    }
}
