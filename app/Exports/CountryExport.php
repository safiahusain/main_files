<?php

namespace App\Exports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class CountryExport implements FromCollection, WithHeadings
{
    protected $is_dummy = false;
    protected $first_item = null;

    public function __construct($is_dummy, $first_item)
    {
        $this->is_dummy = $is_dummy;
        $this->first_item = $first_item;
    }

    public function headings(): array
    {
        return
            $this->is_dummy ? [
                'Name'
            ] :
            [
                'Id',
                'Name'
            ]
            ;
    }

    public function collection()
    {
        $first_id = $this->first_item ? $this->first_item->id : 0;
        return $this->is_dummy ? Country::select('name')->where('id', $first_id)->get() : Country::select('id','name')->get();
    }
}
