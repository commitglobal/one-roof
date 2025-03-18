<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Shelter\Resources\BeneficiaryResource;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\StayInfolist;
use App\Models\Stay;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;

class ViewStay extends ViewRecord
{
    use UsesBreadcrumbFromTitle;

    public Stay $stay;

    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        abort_if($this->stay->beneficiary_id !== $this->record->id, 404);
    }

    public function getTitle(): string
    {
        return \sprintf(
            '%s #%s %s–%s',
            Str::ucfirst(__('app.stay.label.singular')),
            $this->stay->id,
            $this->stay->start_date->toFormattedDate(),
            $this->stay->end_date->toFormattedDate()
        );
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->stay)
            ->schema(StayInfolist::getSchema());
    }
}
