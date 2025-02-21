<?php

declare(strict_types=1);

namespace App\Filament\Admin\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MergeBulkAction extends BulkAction
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'merge';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('actions.merge.multiple.label'));

        $this->modalHeading(fn () => __('actions.merge.multiple.modal.heading', ['label' => $this->getPluralModelLabel()]));

        $this->modalSubmitActionLabel(__('actions.merge.multiple.modal.actions.merge.label'));

        $this->successNotificationTitle(__('actions.merge.multiple.notifications.merged.title'));

        $this->color('warning');

        $this->outlined();

        // $this->icon(FilamentIcon::resolve('actions::merge-action') ?? 'heroicon-m-trash');

        $this->requiresConfirmation();

        $this->modalIcon(FilamentIcon::resolve('actions::merge-action.modal') ?? 'heroicon-o-trash');

        $this->action(function () {
            $this->process(static function (Collection $records) {
                $keep = $records
                    ->sortBy('id')
                    ->first();

                $records = $records->reject(fn (Model $record) => $record->is($keep));

                $data = $keep->toArray();

                $records->each(function (Model $record) use (&$data) {
                    $data = array_merge_recursive($data, $record->toArray());
                });

                $keep->update($data);

                // TODO: handle relationships

                $records->each->delete();
            });

            $this->success();
        });

        $this->deselectRecordsAfterCompletion();
    }
}
