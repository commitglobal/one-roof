<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Enums\Form\FieldType;
use App\Models\Form\Field;
use App\Models\Form\Response;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class BeneficiaryDynamicInfolist
{
    public static function getSchema(): array
    {
        return [
            Group::make()
                ->relationship('latestPersonal')
                ->columnSpanFull()
                ->schema(function (?Response $state) {
                    if (blank($state)) {
                        return [];
                    }

                    $state->loadMissing('form.sections.fields:id,label,type,section_id');

                    $fieldIndex = 0;

                    return $state->form
                        ->sections
                        ->map(function ($section) use (&$fieldIndex) {
                            return Section::make($section->name)
                                ->description($section->description)
                                ->columns(3)
                                ->collapsible()
                                ->schema(function () use ($section, &$fieldIndex) {
                                    return $section->fields->map(function (Field $field) use (&$fieldIndex) {
                                        $component = TextEntry::make("fields.{$fieldIndex}.value")
                                            ->label($field->label);

                                        $fieldIndex++;

                                        switch ($field->type) {
                                            case FieldType::CHECKBOX:
                                            case FieldType::RADIO:
                                            case FieldType::SELECT:
                                                $component->listWithLineBreaks();
                                                break;

                                            case FieldType::NUMBER:
                                                $component->numeric();
                                                break;

                                            case FieldType::DATE:
                                                $component->date();
                                                break;
                                        }

                                        return $component;
                                    })->all();
                                });
                        })->all();
                }),
        ];
    }
}
