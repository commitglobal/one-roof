<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Pages;

use App\Enums\Form\Type;
use App\Filament\Concerns\UsesBreadcrumbFromTitle;
use App\Filament\Shelter\Resources\BeneficiaryResource;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\BeneficiaryForm;
use App\Filament\Shelter\Resources\BeneficiaryResource\Schemas\StayForm;
use App\Models\Beneficiary;
use App\Models\Form;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\Concerns\HasWizard;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\MaxWidth;

class CreateBeneficiary extends CreateRecord
{
    use HasWizard;
    use UsesBreadcrumbFromTitle;

    protected static string $resource = BeneficiaryResource::class;

    public function getSteps(): array
    {
        return [
            Step::make(__('app.beneficiary.steps.consent'))
                ->maxWidth(MaxWidth::ThreeExtraLarge)
                ->schema([
                    Checkbox::make('consent')
                        ->label(__('app.field.create_beneficiary_consent'))
                        ->validationAttribute(' ')
                        ->accepted()
                        ->columnSpanFull(),
                ]),

            // Step::make(__('app.beneficiary.steps.identification'))
            //     ->schema([
            //         Select::make('beneficiary_id')
            //             ->relationship('beneficiary', 'name')
            //             ->label(__('app.field.create_beneficiary_search'))
            //             ->placeholder(__('app.placeholder.create_beneficiary_search'))
            //             ->helperText(__('app.field_help.create_beneficiary_search'))
            //             ->lazy()
            //             ->searchable()
            //             ->required(fn (Get $get) => $get('beneficiary_not_applicable') !== true)
            //             ->disabled(fn (Get $get) => $get('beneficiary_not_applicable') === true)
            //             ->columnSpanFull()
            //             ->afterStateUpdated(function ($state, $record) {
            //                 debug($state, $record);
            //             }),

            //         Checkbox::make('beneficiary_not_applicable')
            //             ->label(__('app.field.not_applicable'))
            //             ->live(),
            //     ]),

            Step::make(__('app.beneficiary.steps.personal_details'))
                ->schema([
                    Grid::make(3)
                        ->schema(BeneficiaryForm::getSchema()),

                    ...Form::render(Type::PERSONAL),
                ]),

            Step::make(__('app.beneficiary.steps.stay'))
                ->schema([
                    Group::make()
                        ->relationship('latestStay')
                        ->schema(StayForm::getSchema()),
                ]),
        ];
    }

    protected function handleRecordCreation(array $data): Beneficiary
    {
        $beneficiary = parent::handleRecordCreation($data);

        $this->saveCustomFormData($beneficiary, $data);

        return $beneficiary;
    }

    protected function saveCustomFormData(Beneficiary $beneficiary, array $data): void
    {
        $form = Form::query()
            ->latestPublished(Type::PERSONAL)
            ->first(['id']);

        if (blank($form)) {
            return;
        }

        $personal = $beneficiary->personal()->create([
            'form_id' => $form->id,
        ]);

        $personal->fields()->createMany(
            collect(data_get($data, 'form'))
                ->map(fn ($value, $field_id) => [
                    'field_id' => $field_id,
                    'value' => $value,
                ])
                ->toArray()
        );
    }
}
