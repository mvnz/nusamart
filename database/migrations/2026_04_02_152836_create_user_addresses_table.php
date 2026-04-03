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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label')->default('Rumah');
            $table->string('recipient_name');
            $table->string('phone', 20);
            $table->string('alamat');
            $table->char('province_code', 2);
            $table->char('regency_code', 4);
            $table->string('district_code', 8);
            $table->string('village_code', 10);
            $table->string('propinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('kodepos', 5);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
