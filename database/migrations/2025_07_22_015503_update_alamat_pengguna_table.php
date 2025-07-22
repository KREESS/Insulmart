<?php
// database/migrations/2025_07_22_000000_create_alamat_pengguna_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop tabel lama jika ada
        Schema::dropIfExists('alamat_pengguna');

        // Buat ulang tabel sesuai form, tanpa FK ke provinces/regencies/districts/villages
        Schema::create('alamat_pengguna', function (Blueprint $table) {
            $table->id();
            // relasi ke users
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // kolom untuk menyimpan pilihan dari JSON
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('regency_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('village_id');

            // detail alamat
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('kode_pos', 10);
            $table->text('alamat_lengkap');

            // flag alamat default
            $table->boolean('is_default')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamat_pengguna');
    }
};
