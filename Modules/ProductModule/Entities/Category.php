<?php

namespace Modules\ProductModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category_name', 'category_slug', 'category_image', 'is_status', 'user_id',];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    protected static function newFactory()
    {
        return \Modules\ProductModule\Database\factories\CategorySeederFactpryFactory::new();
    }
}
