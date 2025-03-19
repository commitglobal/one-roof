<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Shelter\Resources\BeneficiaryResource;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\DocumentForm;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\DocumentInfolist;
use App\Models\Document;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewDocument extends ViewRecord
{
    use UsesBreadcrumbFromTitle;

    public Document $document;

    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label(__('app.documents.actions.delete'))
                ->record($this->document)
                ->recordTitle($this->getTitle())
                ->icon('heroicon-o-trash')
                ->outlined()
                ->authorize(fn (Document $record) => Filament::auth()->user()->can('delete', $record))
                ->successRedirectUrl(fn () => BeneficiaryResource::getUrl('view', ['record' => $this->record])),

            Actions\EditAction::make()
                ->label(__('app.documents.actions.edit'))
                ->record($this->document)
                ->recordTitle($this->getTitle())
                ->icon('heroicon-o-pencil-square')
                ->color('gray')
                ->outlined()
                ->authorize(fn (Document $record) => Filament::auth()->user()->can('update', $record))
                ->form(DocumentForm::getSchema())
                ->url(null),

            Actions\Action::make('download')
                ->record($this->document)
                ->label(__('app.documents.actions.download'))
                ->outlined()
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->outlined()
                ->disabled(fn (Document $record) => $record->media->isEmpty())
                ->action(function (Document $record) {
                    $mediaItem = $record->media->first();

                    return response()->download($mediaItem->getPath(), $mediaItem->file_name);
                }),
        ];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        abort_if($this->document->beneficiary_id !== $this->record->id, 404);
    }

    public function getTitle(): string
    {
        return \sprintf('#%s %s', $this->document->id, $this->document->name);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->document)
            ->schema(DocumentInfolist::getSchema());
    }
}
