<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_return_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_return_id')->constrained('sale_returns')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('sale_item_id')->constrained('sales_items')->onDelete('cascade'); // Track original sale item
            $table->integer('quantity'); // Quantity returned
            $table->decimal('rate', 10, 2); // Price per unit at time of sale
            $table->text('remarks')->nullable(); // Optional note for return
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_return_items');
    }
};
