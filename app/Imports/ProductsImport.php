<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
           'reference'      => $row['reference'],
           'description'    => $row['description'],
           'brand'          => $row['brand'],
           'list'           => $row['list'],
           'minimum_amount' => $row['minimum_amount'],
           'price_a'        => number_format($row['price_a'], 2, '.', ''),
           'price_b'        => $row['price_b'],
           'price_c'        => $row['price_c'],
           'price_d'        => $row['price_d'],
        ]);
    }
}
