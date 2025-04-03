<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScoutDeleteAllIndexesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:delete-all-indexes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all indexes';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        app('searchable-models')
            ->each(function (string $model): void {
                $this->call('scout:delete-index', ['name' => (new $model)->searchableAs()]);
            });

        return self::SUCCESS;
    }
}
