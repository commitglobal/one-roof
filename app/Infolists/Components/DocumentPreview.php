<?php

declare(strict_types=1);

namespace App\Infolists\Components;

use App\Models\Media;
use Closure;
use Filament\Infolists\Components\Entry;

class DocumentPreview extends Entry
{
    protected string $view = 'infolists.components.document-preview';

    protected string | Closure $collection = 'default';

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function collection(string | Closure $collection): static
    {
        $this->collection = $collection;

        return $this;
    }

    public function getCollection(): string
    {
        return $this->evaluate($this->collection);
    }

    public function getFile(): ?Media
    {
        return $this->getRecord()
            ->getFirstMedia($this->getCollection());
    }
}
