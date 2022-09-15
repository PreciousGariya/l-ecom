<?php

namespace Modules\ProductModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'keywords', 'short_description', 'image', 'category_id', 'long_description', 'price', 'discount_price','slug', 'stock','product_sale_tag', 'user_id', 'is_status',];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    protected static function newFactory()
    {
        return \Modules\ProductModule\Database\factories\ProductSeederFactoryFactory::new();
    }
}
