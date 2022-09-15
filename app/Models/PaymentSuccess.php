<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSuccess extends Model
{
    use HasFactory;
    protected $fillable=[ 'customer_id', 'order_id', 'amount_received', 'currency', 'Stripe_customer', 'description', 'amount_captured', 'charge_id', 'payment_intent', 'payment_method', 'paid_status', 'captured_status', 'receipt_url', 'payment_method_details', 'payment_status'];
}
