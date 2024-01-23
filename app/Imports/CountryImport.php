<?php

namespace App\Imports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Str;
class CountryImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }


    public function model(array $row)
    {
        return new Country([
            'name' => $row[0],
            'slug' => Str::slug($row[0]).rand(10, 10000),
            'status' => 1
        ]);
    }
}
