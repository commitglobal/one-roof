<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\BeneficiaryResource\Schemas;

use App\Enums\Form\FieldType;
use App\Models\Form\Field;
use App\Models\Form\Response;
use Carbon\Carbon;
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

                    return static::getSchemaForResponse($state);
                }),
        ];
    }

    public static function getSchemaForResponse(Response $response): array
    {
        $fieldIndex = 0;

        return $response->form
            ->sections
            ->map(function ($section) use (&$fieldIndex) {
                return Section::make($section->name)
                    ->description($section->description)
                    ->columns(3)
                    ->collapsible()
                    ->schema(
                        $section->fields->map(function (Field $field) use (&$fieldIndex) {
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
                                    $component->formatStateUsing(function ($state) {
                                        return rescue(fn () => Carbon::parse($state)->toFormattedDate(), $state, false);
                                    });
                                    break;
                            }

                            return $component;
                        })->all()
                    );
            })->all();
    }
}
