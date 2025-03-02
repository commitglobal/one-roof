<?php

declare(strict_types=1);

namespace App\Enums\Form;

use App\Enums\Concerns\Arrayable;
use App\Enums\Concerns\Comparable;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;

enum Field: string implements HasLabel
{
    use Arrayable;
    use Comparable;

    case CHECKBOX = 'checkbox';
    case DATE = 'date';
    case EMAIL = 'email';
    case NUMBER = 'number';
    case RADIO = 'radio';
    case SELECT = 'select';
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case URL = 'url';

    public function getLabel(): string
    {
        return match ($this) {
            self::CHECKBOX => __('app.form_field.checkbox'),
            self::DATE => __('app.form_field.date'),
            self::EMAIL => __('app.form_field.email'),
            self::NUMBER => __('app.form_field.number'),
            self::RADIO => __('app.form_field.radio'),
            self::SELECT => __('app.form_field.select'),
            self::TEXT => __('app.form_field.text'),
            self::TEXTAREA => __('app.form_field.textarea'),
            self::URL => __('app.form_field.url'),
        };
    }

    public function getComponent(): string
    {
        return match ($this) {
            self::CHECKBOX => CheckboxList::class,
            self::DATE => DatePicker::class,
            self::RADIO => Radio::class,
            self::SELECT => Select::class,
            self::TEXTAREA => Textarea::class,
            // self::EMAIL, self::NUMBER, self::TEXT, self::URL => TextInput::class,
            default => TextInput::class,
        };
    }
}
