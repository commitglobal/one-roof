<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Shelter\Resources\BeneficiaryResource;
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
            BeneficiaryResource\Actions\ExtendStayAction::make()
                ->record($this->stay),
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
            '%s %s',
            Str::ucfirst(__('app.stay.label.singular')),
            $this->stay->title
        );
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->stay)
            ->schema(BeneficiaryResource\Schemas\StayInfolist::getSchema());
    }
}
