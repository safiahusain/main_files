<?php

namespace App\Exports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CityExport implements FromCollection, WithHeadings
{
    protected $is_dummy = false;

    public function __construct($is_dummy)
    {
        $this->is_dummy = $is_dummy;
    }

    public function headings(): array
    {
        return
            $this->is_dummy ? [
                'State Id',
                'Name'
            ] :
            [
                'Id',
                'State Id',
                'Name'
            ]
            ;
    }


    public function collection()
    {
        $first_item = City::first();
        $first_id = $first_item ? $first_item->id : 0;

        return $this->is_dummy ? City::select('country_state_id','name')->where('id', $first_id)->get() : City::select('id','country_state_id','name')->get();
    }
}
