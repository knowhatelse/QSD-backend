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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price');
            $table->string('availability_state'); //Da li treba da je string ili enum za više stanja ili bool za da je dostupno/nije dostupno?
            $table->integer('total_rating')->nullable();
            $table->float('average_rating')->nullable();
            $table->boolean('is_favorite')->nullable(); //Da li da se i ovdje stavi default vrijednost na false?
            $table->enum('gender', [1,2,3])->comment('1 - male, 2 - female, 3 - child')->default('1');
            $table->foreignId('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreignId('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
