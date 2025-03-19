<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Shelter\Resources\BeneficiaryResource;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\BeneficiaryDynamicInfolist;
use App\Models\Form\Response;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewPersonalDataVersion extends ViewRecord
{
    use UsesBreadcrumbFromTitle;

    public Response $response;

    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->response)
            ->schema(fn (Response $record) => [
                Section::make()
                    ->columns(3)
                    ->schema([
                        TextEntry::make('id')
                            ->label(__('app.field.id'))
                            ->prefix('#'),

                        TextEntry::make('created_at')
                            ->label(__('app.field.created_at'))
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label(__('app.field.updated_at'))
                            ->dateTime(),
                    ]),

                ...BeneficiaryDynamicInfolist::getSchemaForResponse($record),
            ]);
    }
}
