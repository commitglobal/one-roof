<?php

declare(strict_types=1);

namespace App\Models\Form;

use App\Enums\Form\FieldType;
use Database\Factories\Form\FieldFactory;
use Filament\Forms\Components\Field as Component;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Field extends Model
{
    /** @use HasFactory<FieldFactory> */
    use HasFactory;
    use HasTranslations;

    protected $table = 'form_fields';

    protected static string $factory = FieldFactory::class;

    protected $fillable = [
        'section_id',
        'label',
        'help',
        'type',
        'required',
        'options',
        'min',
        'max',
        'order',
    ];

    public array $translatable = [
        'label',
        'help',
        'options',
    ];

    protected function casts(): array
    {
        return [
            'type' => FieldType::class,
            'options' => 'collection',
            'required' => 'boolean',
            'min' => 'integer',
            'max' => 'integer',
            'order' => 'integer',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function render(): Component
    {
        /** @var Component */
        $component = $this->type->getComponent()::make("form.{$this->id}")
            ->label($this->label)
            ->helperText($this->help)
            ->required($this->required);

        switch ($this->type) {
            case FieldType::CHECKBOX:
            case FieldType::RADIO:
            case FieldType::SELECT:
                $component
                    ->options(
                        Str::of($this->options)
                            ->split('/\r\n|\r|\n/')
                            ->filter()
                    );
                break;

            case FieldType::NUMBER:
                $component
                    ->minValue($this->min ?: null)
                    ->maxValue($this->max ?: null);
                break;

            case FieldType::TEXT:
            case FieldType::TEXTAREA:
                $component
                    ->minLength($this->min ?: null)
                    ->maxLength($this->max ?: null);
                break;
        }

        return $component;
    }
}
