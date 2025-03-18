<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Filament\Shelter\Resources\BeneficiaryResource;
use App\Models\Form\FieldResponse;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBeneficiary extends EditRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected ?bool $hasDatabaseTransactions = true;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }

    /**
     * TODO: handle the case where the form hasn't been submitted before.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['form'] = $this->getRecord()->latestPersonal
            ?->fields
            ->pluck('value', 'field_id')
            ->all();

        return $data;
    }

    /**
     * TODO: handle the case where the form hasn't been submitted before.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $response_id = $this->getRecord()->latestPersonal->id;

        $this->wrapInDatabaseTransaction(
            fn () => collect(data_get($data, 'form'))->each(
                fn ($value, int $field_id) => FieldResponse::query()
                    ->where('response_id', $response_id)
                    ->where('field_id', $field_id)
                    ->update([
                        'value' => json_encode($value),
                    ])
            )
        );

        return $data;
    }
}
