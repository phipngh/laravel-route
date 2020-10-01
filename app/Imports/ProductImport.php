<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'catelogy_id' => $row["catelogy_id"],
            'gender_id' => $row["gender_id"],
            'name' => $row["name"],
            'description' => $row["description"],
            'price' => $row["price"],
            'image' => $row["image"],
        ]);
    }
}
