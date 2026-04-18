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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();                        // e.g. LEBARAN20
            $table->string('name', 150);                                 // display name
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed']);      // % or Rp
            $table->decimal('discount_value', 12, 2)->unsigned();        // 20 or 10000
            $table->decimal('max_discount', 12, 2)->unsigned()->nullable(); // cap for percentage type
            $table->decimal('min_purchase', 12, 2)->unsigned()->default(0); // minimum order total
            $table->unsignedInteger('quota')->default(0);                // 0 = unlimited
            $table->unsignedInteger('used_count')->default(0);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
