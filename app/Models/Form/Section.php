<?php

declare(strict_types=1);

namespace App\Models\Form;

use App\Models\Form;
use Database\Factories\Form\SectionFactory;
use Filament\Forms\Components\Section as Component;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    /** @use HasFactory<SectionFactory> */
    use HasFactory;
    use HasTranslations;

    protected $table = 'form_sections';

    protected static string $factory = SectionFactory::class;

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
        return $this->hasMany(Field::class)
            ->orderBy('order', 'asc');
    }

    public function render(): Component
    {
        return Component::make($this->name)
            ->description($this->description)
            ->compact()
            ->schema(
                $this->fields
                    ->map->render()
                    ->all()
            );
    }
}
