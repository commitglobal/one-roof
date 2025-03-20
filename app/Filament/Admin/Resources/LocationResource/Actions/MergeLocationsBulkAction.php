<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\LocationResource\Actions;

use App\Models\Organization;
use App\Models\Shelter;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MergeLocationsBulkAction extends BulkAction
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

        $this->icon(FilamentIcon::resolve('actions::merge-action') ?? 'majestic-git-pull-line');

        $this->requiresConfirmation();

        $this->modalIcon(FilamentIcon::resolve('actions::merge-action.modal') ?? 'majestic-git-pull-line');

        $this->action(function (Collection $records) {
            $keep = $records
                ->sortBy('id')
                ->first();

            $records = $records->reject(fn (Model $record) => $record->is($keep));

            $name = data_get($keep->toArray(), 'name');

            $records->each(function (Model $record) use (&$name) {
                $name = array_merge_recursive($name, data_get($record->toArray(), 'name'));
            });

            $name = collect($name)
                ->map(function (array | string $items) {
                    if (\is_array($items)) {
                        return collect($items)
                            ->unique()
                            ->join(', ');
                    }

                    return $items;
                })
                ->toArray();

            DB::transaction(function () use ($records, $keep, $name) {
                $keep->replaceTranslations('name', $name)
                    ->save();

                Organization::query()
                    ->whereIn('location_id', $records->pluck('id'))
                    ->get()
                    ->each->update(['location_id' => $keep->id]);

                Shelter::query()
                    ->whereIn('location_id', $records->pluck('id'))
                    ->get()
                    ->each->update(['location_id' => $keep->id]);

                $records->each->delete();
            });

            $this->success();
        });

        $this->deselectRecordsAfterCompletion();
    }
}
