<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopingCart extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'product_name',
        'product_id',
        'slug',
        'quantity',
        'price',
        'image',
    ];
}
