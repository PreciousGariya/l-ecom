<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = ['fname', 'lname', 'cname', 'billing_address', 'billing_address2', 'city', 'state', 'zipcode', 'phone', 'email','created_at'];
    use HasFactory;
}
