<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\FormSectionFactory;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class FormSection extends Model
{
    /** @use HasFactory<FormSectionFactory> */
    use HasFactory;
    use HasTranslations;

    protected static string $factory = FormSectionFactory::class;

    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class, 'section_id')
            ->orderBy('order', 'asc');
    }

    public function render(): Section
    {
        return Section::make($this->name)
            ->description($this->description)
            ->schema(
                $this->fields
                    ->map->render()
                    ->all()
            );
    }
}
