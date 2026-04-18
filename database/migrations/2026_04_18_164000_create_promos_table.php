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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // penjual
            $table->decimal('original_price', 12, 2);
            $table->decimal('promo_price', 12, 2);
            $table->integer('discount_percentage')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('quota')->default(0); // 0 = unlimited
            $table->integer('used_quota')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes untuk query yang cepat
            $table->index('product_id');
            $table->index('user_id');
            $table->index('is_active');
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
