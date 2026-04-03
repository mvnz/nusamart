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
        Schema::create('courier_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courier_id')->constrained()->onDelete('cascade');
            $table->string('name');           // Reguler, Express, Ekonomi
            $table->string('code', 20);       // REG, YES, OKE
            $table->string('estimated_days', 30)->nullable(); // 2-3 hari
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_services');
    }
};
