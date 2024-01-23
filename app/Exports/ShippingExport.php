<?php

namespace App\Exports;

use App\Models\Shipping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShippingExport implements FromCollection, WithHeadings
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
                'City Id',
                'Shipping rule',
                'Type',
                'Condition From',
                'Condition To',
                'Shipping Fee',
            ] :
            [
                'Id',
                'City Id',
                'Shipping rule',
                'Type',
                'Condition From',
                'Condition To',
                'Shipping Fee',
            ]
            ;
    }
    public function collection()
    {
        $first_item = Shipping::first();
        $first_id = $first_item ? $first_item->id : 0;

        return $this->is_dummy ? Shipping::select('city_id','shipping_rule','type','condition_from','condition_to','shipping_fee')->where('id', $first_id)->get() : Shipping::select('id','city_id','shipping_rule','type','condition_from','condition_to','shipping_fee')->get();
    }
}
