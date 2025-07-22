<?php
// database/migrations/2025_07_21_000001_create_alamat_quotation_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alamat_quotation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')
                ->constrained('quotations')
                ->cascadeOnDelete();
            $table->string('nama_penerima');
            $table->string('jalan');
            $table->string('kota');
            $table->string('kode_pos');
            $table->string('negara');
            $table->string('telepon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamat_quotation');
    }
};
