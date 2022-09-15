<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_successes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('order_id');
            $table->double('amount_received');
            $table->string('currency');
            $table->string('Stripe_customer');
            $table->text('description');
            $table->double('amount_captured');
            $table->string('charge_id');
            $table->string('payment_intent');
            $table->string('payment_method');
            $table->string('paid_status');
            $table->string('captured_status');
            $table->string('receipt_url');
            $table->string('payment_method_details');
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_successes');
    }
};
