<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use Modules\ProductModule\Entities\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'title'     => $row['title'],
            'keywords'    => $row['keywords'],
            'short_description' => $row['short_description'],
            'image' => $row['image'],
            'category_id' => $row['category_id'],
            'long_description' => $row['long_description'],
            'price' => $row['price'],
            'discount_price' => $row['discount_price'],
            'stock' => $row['user_id'],
            'slug' => Str::random(30),
            'is_status' => $row['is_status'],
            'product_sale_tag'=>$row['product_sale_tag'],
            'user_id' => Auth::user()->id,

        ]);
    }
}
