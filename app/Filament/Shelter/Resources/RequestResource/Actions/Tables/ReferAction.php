<?php

declare(strict_types=1);

namespace App\Filament\Shelter\Resources\RequestResource\Actions\Tables;

use App\Filament\Shelter\Resources\RequestResource;
use App\Models\Shelter;
use Filament\Facades\Filament;
use Filament\Forms\Components\Textarea;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;

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

        $this->iconPosition(IconPosition::After);

        $this->modalHeading(
            fn (array $arguments) => __('app.request.actions.refer.confirm.title', [
                'request' => data_get($arguments, 'request.id'),
            ])
        );

        $this->modalDescription(
            fn (Shelter $record) => __('app.request.actions.refer.confirm.description', [
                'shelter' => $record->name,
            ])
        );

        $this->modalWidth('md');

        $this->form([
            Textarea::make('referal_notes')
                ->label(__('app.field.notes'))
                ->rows(5),
        ]);

        $this->action(function (Shelter $record, array $data, array $arguments) {
            $request = data_get($arguments, 'request');

            if (
                blank($request) ||
                $request->shelter_id === $record->id ||
                $request->shelter_id !== Filament::getTenant()->id
            ) {
                $this->failure();

                return;
            }

            $request->referToShelter($record, data_get($data, 'referal_notes'));

            $this->success();
        });

        $this->successNotificationTitle(
            fn (Shelter $record) => __('app.request.actions.refer.confirm.success', [
                'shelter' => $record->name,
            ])
        );

        $this->successRedirectUrl(RequestResource::getUrl('index'));
    }
}
