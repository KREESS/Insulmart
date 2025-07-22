<?php
// database/migrations/2025_07_21_000000_create_alamat_pengguna_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alamat_pengguna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('label')->nullable();       // misal: “Rumah”, “Kantor”
            $table->string('jalan');
            $table->string('kota');
            $table->string('kode_pos');
            $table->string('negara');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamat_pengguna');
    }
};
