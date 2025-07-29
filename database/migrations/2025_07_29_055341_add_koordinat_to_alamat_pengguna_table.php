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
        Schema::table('alamat_pengguna', function (Blueprint $table) {
            // Kolom koordinat wajib diisi, dengan default awal agar tidak error saat migrate
            $table->string('koordinat')
                ->default('0.000000,0.000000')
                ->after('alamat_lengkap');
        });
    }

    public function down(): void
    {
        Schema::table('alamat_pengguna', function (Blueprint $table) {
            $table->dropColumn('koordinat');
        });
    }
};
