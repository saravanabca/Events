<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing primary key column named 'id'
            $table->unsignedBigInteger('product_id'); // Product ID
            $table->string('name', 255); // Product name
            $table->text('description'); // Product description
            $table->decimal('price', 10, 2); // Product price
            $table->string('image', 255); // Image URL or path
            $table->integer('quantity'); // Quantity
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};