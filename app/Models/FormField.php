<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Form\Field;
use Database\Factories\FormFieldFactory;
use Filament\Forms\Components\Field as Component;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class FormField extends Model
{
    /** @use HasFactory<FormFieldFactory> */
    use HasFactory;
    use HasTranslations;

    protected static string $factory = FormFieldFactory::class;

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
            'type' => Field::class,
            'options' => 'collection',
            'required' => 'boolean',
            'min' => 'integer',
            'max' => 'integer',
            'order' => 'integer',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(FormSection::class, 'section_id');
    }

    public function render(): Component
    {
        /** @var Component */
        $component = $this->type->getComponent()::make("form.{$this->id}")
            ->label($this->label)
            ->helperText($this->help)
            ->required($this->required);

        return $component;
    }
}
