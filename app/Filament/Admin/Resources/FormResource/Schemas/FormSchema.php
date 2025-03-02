<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\FormResource\Schemas;

use App\Enums\Form\Field;
use App\Forms\Components\Repeater;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Support\Enums\Alignment;

class FormSchema
{
    public static function getSectionSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('app.field.section_name'))
                ->lazy()
                ->required()
                ->translatable(),

            RichEditor::make('description')
                ->label(__('app.field.description'))
                ->translatable(),

            Repeater::make('fields')
                ->relationship('fields')
                ->label(__('app.field.fields'))
                ->reorderable()
                ->orderColumn('order')
                ->minItems(1)
                ->addActionAlignment(Alignment::Start)
                ->addAction(
                    fn (Action $action) => $action
                        ->icon('heroicon-s-plus')
                        ->color('primary')
                        ->link()
                )
                ->itemLabel(
                    fn (array $state) => collect([
                        Field::tryFrom((string) data_get($state, 'type'))?->getLabel(),
                        data_get($state, 'label.' . app()->getLocale()),
                    ])
                        ->filter()
                        ->join(': ')
                )
                ->cloneable()
                ->collapsible()
                ->schema(static::getFieldSchema()),
        ];
    }

    public static function getFieldSchema(): array
    {
        return [
            TextInput::make('label')
                ->label(__('app.field.label'))
                ->lazy()
                ->required()
                ->translatable(),

            TextInput::make('help')
                ->label(__('app.field.help'))
                ->nullable()
                ->translatable(),

            Toggle::make('required')
                ->label(__('app.field.required')),

            Select::make('type')
                ->label(__('app.field.type'))
                ->options(Field::options())
                ->enum(Field::class)
                ->live()
                ->required(),

            Textarea::make('options')
                ->label(__('app.field.options'))
                ->helperText(__('app.field_help.one_per_line'))
                ->nullable()
                ->rows(5)
                ->visible(
                    fn (Get $get) => \in_array(Field::tryFrom((string) $get('type')), [
                        Field::CHECKBOX,
                        Field::RADIO,
                        Field::SELECT,
                    ])
                ),

            Group::make()
                ->visible(
                    fn (Get $get) => \in_array(Field::tryFrom((string) $get('type')), [
                        Field::NUMBER,
                    ])
                )
                ->schema([
                    TextInput::make('min')
                        ->label(__('app.field.min_value'))
                        ->helperText(__('app.field_help.zero_to_disable'))
                        ->integer()
                        ->minValue(0)
                        ->default(0),

                    TextInput::make('max')
                        ->label(__('app.field.max_value'))
                        ->helperText(__('app.field_help.zero_to_disable'))
                        ->integer()
                        ->minValue(0)
                        ->default(0),
                ]),

            Group::make()
                ->visible(
                    fn (Get $get) => \in_array(Field::tryFrom((string) $get('type')), [
                        Field::TEXT,
                        Field::TEXTAREA,
                    ])
                )
                ->schema([
                    TextInput::make('min')
                        ->label(__('app.field.min_length'))
                        ->helperText(__('app.field_help.zero_to_disable'))
                        ->integer()
                        ->minValue(0)
                        ->default(0),

                    TextInput::make('max')
                        ->label(__('app.field.max_length'))
                        ->helperText(__('app.field_help.zero_to_disable'))
                        ->integer()
                        ->minValue(0)
                        ->default(0),
                ]),
        ];
    }
}
