<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CountriesImport implements ToModel, WithBatchInserts, WithHeadingRow
{
    public function model(array $row): ?Country
    {
        return new Country([
            'id' => $row['id'],
            'name' => [
                'en' => $row['name_en'],
            ],
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }
}
