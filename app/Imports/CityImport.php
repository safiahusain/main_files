<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Str;
class CityImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }


    public function model(array $row)
    {
        return new City([
            'country_state_id' => $row[0],
            'name' => $row[1],
            'slug' => Str::slug($row[1]).rand(100, 1000),
            'status' => 1,
        ]);
    }
}
