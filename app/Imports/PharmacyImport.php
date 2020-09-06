<?php

namespace App\Imports;

use App\Pharmacy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PharmacyImport implements ToModel, WithHeadingRow, WithChunkReading
{
    public function model(array $row)
    {
        if (is_null($row['lat'])) return null;
        if (is_null($row['lng'])) return null;

        return new Pharmacy([
            'name' => $row['name'],
            'type' => 1,
            'lat' => $row['lat'],
            'lng' => $row['lng'],
            'addr' => $row['addr'],
            'tel' => $row['tel'],
        ]);
    }

    public function chunkSize(): int
    {
        return 4000;
    }
}
