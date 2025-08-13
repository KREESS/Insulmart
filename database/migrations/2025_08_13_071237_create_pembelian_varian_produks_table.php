<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembelian_varian_produks', function (Blueprint $table) {
            $table->id();

            // Relasi ke varian_produks
            $table->foreignId('varian_id')
                ->constrained('varian_produks')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Jumlah barang
            $table->decimal('qty', 18, 3);

            // Harga satuan & total harga
            $table->decimal('harga_satuan', 18, 2)->default(0);
            $table->decimal('total_harga', 18, 2)->default(0); // qty * harga_satuan

            // Status bahasa Indonesia
            $table->enum('status', [
                'draft',
                'dipesan',
                'dikirim',
                'diterima_sebagian',
                'selesai',
                'dibatalkan',
                'dikembalikan_ke_supplier',
            ])->default('draft');

            $table->dateTime('tanggal_beli')->nullable();
            $table->string('catatan', 255)->nullable();

            // Index berguna
            $table->index(['varian_id', 'status']);
            $table->index('tanggal_beli');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelian_varian_produks');
    }
};
