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
        Schema::create('promo_slots', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);          // e.g. "Periode 1", "Flash Sale Pagi"
            $table->time('start_time');            // e.g. 10:00:00
            $table->time('end_time');              // e.g. 12:00:00
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_slots');
    }
};
