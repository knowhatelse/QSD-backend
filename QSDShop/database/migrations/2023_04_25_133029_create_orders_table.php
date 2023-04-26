<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->float('subtotal');
            $table->float('total');
            $table->float('delivery_price');
            $table->DateTime('delivery_date');
            $table->integer('quantity');
            $table->string('city');
            $table->string('street_number');
            $table->string('street_name');
            $table->string('postal_code');
            $table->integer('user_id');
            $table->integer('order_product_size_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
