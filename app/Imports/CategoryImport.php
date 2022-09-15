<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\ProductModule\Entities\Category;

class CategoryImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'category_name'     => $row['category_name'],
            'category_slug'    => $row['category_slug'],
            'category_image' => $row['category_image'],
            'is_status' => $row['is_status'],
            'user_id' => Auth::user()->id,

        ]);
    }
}
