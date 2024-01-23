<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class ProductImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {

        return new Product([
            'name' => $row[0],
            'short_name' => $row[1],
            'slug' => $row[2],
            'thumb_image' => $row[3],
            'vendor_id' => $row[4] ? $row[4] : 0,
            'category_id' => $row[5],
            'sub_category_id' => $row[6] ? $row[6] : 0,
            'child_category_id' => $row[7] ? $row[7] : 0,
            'brand_id' => $row[8] ? $row[8] : 0,
            'qty' => $row[9],
            'weight' => $row[10],
            'short_description' => $row[11],
            'long_description' => $row[12],
            'video_link' => $row[13],
            'sku' => $row[14],
            'seo_title' => $row[15],
            'seo_description' => $row[16],
            'price' => $row[17],
            'offer_price' => $row[18],
            'status' => 1,
            'approve_by_admin' => 1
        ]);
    }
}
