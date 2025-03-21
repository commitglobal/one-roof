<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Enums\Form\Type;
use App\Filament\Shelter\Resources\BeneficiaryResource;
use App\Models\Form;
use App\Models\Form\FieldResponse;
use App\Models\Form\Response;
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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['form'] = $this->getRecord()->latestPersonal
            ?->fields
            ->pluck('value', 'field_id')
            ->all();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $form = Form::query()
            ->latestPublished(Type::PERSONAL)
            ->first(['id']);

        if (blank($form)) {
            return $data;
        }

        /** @var Response */
        $response = $this->getRecord()
            ->latestPersonal()
            ->where('form_id', $form->id)
            ->firstOr(
                fn () => $this->getRecord()
                    ->personal()->create([
                        'form_id' => $form->id,
                    ])
            );

        $this->wrapInDatabaseTransaction(function () use ($data, $response) {
            collect(data_get($data, 'form'))->each(
                fn ($value, int $field_id) => FieldResponse::updateOrCreate(
                    [
                        'response_id' => $response->id,
                        'field_id' => $field_id,
                    ],
                    [
                        'value' => $value,
                    ]
                )
            );

            $response->touch();
        });

        return $data;
    }

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('view', [
            'record' => $this->getRecord(),
        ]);
    }
}
