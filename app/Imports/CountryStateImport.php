<?php

namespace App\Imports;

use App\Models\CountryState;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Str;
class CountryStateImport implements ToModel , WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return new CountryState([
            'country_id' => $row[0],
            'name' => $row[1],
            'slug' => Str::slug($row[1]).rand(100, 10000),
            'status' => 1,
        ]);
    }
}
