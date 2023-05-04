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
            $table->integer('total_rating')->default(0);
            $table->float('average_rating')->default(0);
            $table->boolean('is_favorite')->default(0); //Da li da se i ovdje stavi default vrijednost na false?
            $table->enum('gender', [1,2,3])->comment('1 - male, 2 - female, 3 - child')->default('1');
            $table->unsignedBigInteger('brand_id');
            $table->foreignId('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->unsignedBigInteger('color_id');
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
