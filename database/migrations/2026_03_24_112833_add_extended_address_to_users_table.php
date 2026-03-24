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
        Schema::table('users', function (Blueprint $table) {
            $table->char('province_code', 2)->nullable()->after('propinsi');
            $table->char('regency_code', 4)->nullable()->after('province_code');
            $table->char('district_code', 7)->nullable()->after('regency_code');
            $table->char('village_code', 10)->nullable()->after('district_code');
            $table->string('kecamatan')->nullable()->after('kota');
            $table->string('kelurahan')->nullable()->after('kecamatan');
            $table->string('rt', 5)->nullable()->after('kelurahan');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('kodepos', 10)->nullable()->after('rw');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['province_code', 'regency_code', 'district_code', 'village_code', 'kecamatan', 'kelurahan', 'rt', 'rw', 'kodepos']);
        });
    }
};
