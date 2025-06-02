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
        Schema::create('purchase_stocks', function (Blueprint $table) {                                

            $table->id();
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('batch')->nullable(); // Optional batch
            $table->integer('pack')->nullable(); // Optional pack count
            $table->integer('quantity'); // Purchased quantity (excluding bonus)
            $table->integer('bonus')->default(0); // Bonus units if any
            $table->decimal('rate', 10, 2)->default(0); // Bonus units if any
            $table->decimal('cc', 10, 4)->default(0); // Cost contribution per unit
            $table->decimal('cc_on_bonus', 10, 4)->default(0); // Cost contribution on bonus
            $table->decimal('marked_rate', 10, 2); // Rate printed on pack
            $table->decimal('cost_price', 10, 4); // Cost per unit
            $table->decimal('selling_price', 10, 2); // Selling price per unit
            $table->date('expiry_date')->nullable(); // Optional expiry
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_stocks');
    }
};
