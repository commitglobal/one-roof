<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\RequestResource\Actions;

use App\Filament\Shelter\Resources\RequestResource;
use App\Models\Request;
use Filament\Actions\Action;

class ReferAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'refer';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('app.request.actions.refer.button'));

        $this->color('success');

        $this->icon('heroicon-o-paper-airplane');

        $this->url(fn (Request $record) => RequestResource::getUrl('refer', ['record' => $record]));
    }
}
