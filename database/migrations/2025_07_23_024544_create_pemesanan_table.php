<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('alamat_pengiriman_id')->constrained('alamat_pengguna')->onDelete('cascade');
            $table->dateTime('tanggal_pemesanan')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('nomor_po', 100)->nullable();
            $table->string('file_po')->nullable();
            $table->enum('status_po', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->enum('status_pemesanan', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');

            $table->decimal('total_harga', 15, 2);
            $table->enum('metode_pembayaran', ['termin_1x_lunas', 'termin_2x', 'termin_3x'])->default('termin_1x_lunas');

            $table->text('catatan_pelanggan')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
