<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Form\Status;
use App\Enums\Form\Type;
use Database\Factories\FormFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Form extends Model
{
    /** @use HasFactory<FormFactory> */
    use HasFactory;
    use HasTranslations;

    protected static string $factory = FormFactory::class;

    protected $fillable = [
        'name',
        'type',
        'status',
        'description',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'type' => Type::class,
            'status' => Status::class,
        ];
    }

    public function sections(): HasMany
    {
        return $this->hasMany(FormSection::class)
            ->orderBy('order', 'asc');
    }

    public static function booted(): void
    {
        static::creating(function (self $form): void {
            $form->status = Status::DRAFT;
        });

        // When a form is saved as published, mark all other
        // published forms of the same type as obsolete
        static::saving(function (self $form): void {
            if (! $form->isDirty('status')) {
                return;
            }

            if (Status::isValue($form->status, Status::PUBLISHED)) {
                static::query()
                    ->whereNot('id', $form->id)
                    ->where('type', $form->type)
                    ->where('status', Status::PUBLISHED)
                    ->update([
                        'status' => Status::OBSOLETE,
                    ]);
            }
        });
    }

    public function isDraft(): bool
    {
        return Status::isValue($this->status, Status::DRAFT);
    }

    public function isPublished(): bool
    {
        return Status::isValue($this->status, Status::PUBLISHED);
    }

    public function isObsolete(): bool
    {
        return Status::isValue($this->status, Status::OBSOLETE);
    }

    public function markAsDraft()
    {
        return $this->update([
            'status' => Status::DRAFT,
        ]);
    }

    public function markAsPublished()
    {
        return $this->update([
            'status' => Status::PUBLISHED,
        ]);
    }

    public function markAsObsolete()
    {
        return $this->update([
            'status' => Status::OBSOLETE,
        ]);
    }
}
