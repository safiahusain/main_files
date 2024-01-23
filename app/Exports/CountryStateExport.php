<?php

namespace App\Exports;

use App\Models\CountryState;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CountryStateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $is_dummy = false;

    public function __construct($is_dummy)
    {
        $this->is_dummy = $is_dummy;
    }


    public function headings(): array
    {
        return
            $this->is_dummy ? [
                'Country Id',
                'State Name'
            ] :
            [
                'Id',
                'Country Id',
                'State Name'
            ]
            ;
    }


    public function collection()
    {
        $first_item = CountryState::first();
        $first_id = $first_item ? $first_item->id : 0;
        return $this->is_dummy ? CountryState::select('country_id','name')->where('id', $first_id)->get() : CountryState::select('id','country_id','name')->get();
    }
}
