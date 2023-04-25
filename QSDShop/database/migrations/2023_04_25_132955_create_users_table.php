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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("last_name");
            $table->string("email");
            $table->string("phone");
            $table->string("username");
            $table->string("password");
            $table->enum('role', \App\Enums\Role::toArray());
            $table->string('country');
            $table->string('city');
            $table->string('street_number');
            $table->string('street_name');
            $table->string('postal_code');
            $table->string('status');
            $table->integer('order_id');
            $table->integer('favorite_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
