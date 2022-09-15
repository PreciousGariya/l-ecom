<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('keywords')->nullable();
            $table->string('short_description')->nullable();
            $table->integer('image');
            $table->integer('category_id');
            $table->text('long_description')->nullable();
            $table->integer('price');
            $table->integer('discount_price')->nullable();
            $table->integer('stock');
            $table->integer('user_id');
            $table->string('subscription_product')->nullable();
            $table->string('is_status')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('products');
    }
};
